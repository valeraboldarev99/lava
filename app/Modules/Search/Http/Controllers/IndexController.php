<?php

namespace App\Modules\Search\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Search\Models\Search;
use Illuminate\Support\Facades\Validator;
use App\Modules\Search\Models\SearchHistory;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    protected $fieldName;
    protected $resultLimit;
    protected $userContentViewName;

    public function __construct()
    {
        $this->fieldName = getModuleConfig('settings.field_name', 'Search');
        $this->resultLimit = getModuleConfig('settings.result_limit', 'Search');
        $this->userContentViewName = getModuleConfig('settings.user_search_content_view2', 'Search', 'Search::user.search_content');
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
            return view('Search::user.search_results')->withErrors($validator);
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
                if(isset($item['user_search_fields']) && !empty($item['user_search_fields']))
                {
                    $sortBy = isset($item['sort_by_field']) ? $item['sort_by_field'] : 'id';
                    $contentView = isset($item['user_search_content_view']) ? $item['user_search_content_view'] : NULL;
                    $blockTitle = isset($item['block_title']) ? $item['block_title'] : trans($module . '::index.title');
                    $userRoute = isset($item['user_route']) ? $item['user_route'] : NULL;

                    $searchResult = Search::add($item['model_path'], $item['user_search_fields'], $sortBy)
                                            ->beginWithWildcard()                           //добавить в начало поискового слова %
                                            ->includeModelType()                            //добавит в коллекцию имя модели
                                            ->includeRouteName($userRoute)        //добавит в коллекцию имя роута
                                            ->orderByDesc()
                                            ->active()
                                            ->search($query);
// dd($searchResult->where('active', 1));
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
            $validator->errors()->add($this->fieldName, trans('Search::index.errors.many'));

            return view('Search::user.search_results')->withErrors($validator);
        }

        //save search results
        $searchHistory          = $this->getModel();
        $searchHistory->date    = date('Y-m-d H:i:s');
        $searchHistory->lang    = getLang();
        $searchHistory->ip      = ip2long($request->ip());
        $searchHistory->query   = $query;
        $searchHistory->results = $total_result;
        $searchHistory->save();

        return view('Search::user.search_results',[
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
        $viewName = !isset($viewName) ? $this->userContentViewName : $viewName; 

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
            $validator->errors()->add($this->fieldName, trans('Search::index.errors.empty'));

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
            'required' => trans('Search::index.errors.empty'),
            'min'      => trans('Search::index.errors.short_word'),
            'max'      => trans('Search::index.errors.long_word')
        ];
    }
}