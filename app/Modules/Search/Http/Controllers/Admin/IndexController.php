<?php

namespace App\Modules\Search\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Modules\Search\Models\Search;
use Illuminate\Support\Facades\Validator;
use App\Modules\Search\Models\SearchHistory;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    protected $fieldName;
    protected $resultLimit;
    protected $adminContentViewName;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('status');
        $this->share();
        $this->fieldName = getModuleConfig('settings.field_name', 'Search');
        $this->resultLimit = getModuleConfig('settings.result_limit', 'Search');
        $this->adminContentViewName = getModuleConfig('settings.admin_search_content_view', 'Search', 'Search::admin.search_content');
    }

    public function getModel()
    {
        return new SearchHistory();
    }

    public function search(Request $request)
    {
        $query = (string)$request->get($this->fieldName);
        
        //validate
        $validator = $this->validator($query);
        
        if ($validator->fails()) {
            return view('Search::admin.search_results')->withErrors($validator);
        }

        $modules = modules_collect();
        $results = collect();
        $total_result = 0;

        foreach ($modules as $module) {
            $moduleSearchItems = getModuleConfig('settings.search', $module);
            if (!$moduleSearchItems) {
                continue;
            }
            
            foreach($moduleSearchItems as $item)
            {
                if(isset($item['admin_search_fields']) && !empty($item['admin_search_fields']))
                {
                    $sortBy = isset($item['sort_by_field']) ? $item['sort_by_field'] : 'id';
                    $contentView = isset($item['admin_search_content_view']) ? $item['admin_search_content_view'] : NULL;
                    $blockTitle = isset($item['block_title']) ? $item['block_title'] : trans($module . '::adminpanel.title');

                    $searchResult = Search::add($item['model_path'], $item['admin_search_fields'], $sortBy)
                                            ->beginWithWildcard()                           //добавить в начало поискового слова %
                                            ->includeModelType()                            //добавит в коллекцию имя модели
                                            ->includeRouteName($item['admin_route'])        //добавит в коллекцию имя роута
                                            ->orderByDesc()
                                            ->search($query);

                    $content = $this->getContent($searchResult, $blockTitle, $contentView);
                    $total_result += $searchResult->count();

                    if ($content) {
                        $results[$module] = $content;
                    }
                }
                else {
                    continue;
                }
            }
        }

        if ($total_result > $this->resultLimit) {
            $validator->errors()->add($this->fieldName, trans('Search::adminpanel.errors.many'));

            return view('Search::admin.search_results')->withErrors($validator);
        }

        //save search results
        $searchHistory          = $this->getModel();
        $searchHistory->date    = date('Y-m-d H:i:s');
        $searchHistory->lang    = getLang();
        $searchHistory->ip      = ip2long($request->ip());
        $searchHistory->query   = $query;
        $searchHistory->results = $total_result;
        $searchHistory->save();

        return view('Search::admin.search_results',[
            'results' => $results,
            'total_result' => $total_result,
            'query' => $query,
        ]);
    }

    /**
     * @param Collection $entities
     * @param string $title
     * @param string $viewName
     * 
     * @return string 
     */
    protected function getContent($entities, $title, $viewName = NULL) : string
    {
        $viewName = !isset($viewName) ? $this->adminContentViewName : $viewName; 

        return view($viewName, ['title' => $title, 'items' => $entities])->render();
    }

    /**
     * Search validator 
     * @param string $query
     * 
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(&$query)
    {
        $validator = Validator::make([$this->fieldName => $query], $this->getRules(), $this->getMessages());
        if ($validator->fails()) {
            return $validator;
        }
        $query = str_replace(['*', '%'], '', $query);

        if (!$query) {
            $validator->errors()->add($this->fieldName, trans('Search::adminpanel.errors.empty'));

            return $validator;
        }
        return $validator;
    }

    public function getRules() : array
    {
        return [
            $this->fieldName => 'required|min:3|max:70'
        ];
    }

    public function getMessages() : array
    {
        return [
            'required' => trans('Search::adminpanel.errors.empty'),
            'min'      => trans('Search::adminpanel.errors.short_word'),
            'max'      => trans('Search::adminpanel.errors.long_word')
        ];
    }

    protected function share()
    {
        View::share('model_name', class_basename(SearchHistory::class));
    }
}