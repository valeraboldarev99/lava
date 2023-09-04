<?php

namespace App\Modules\Search\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Search\Models\Search;
use Illuminate\Support\Facades\Validator;
use App\Modules\Search\Models\SearchHistory;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public $perPage = 2;
    protected $fieldName;
    protected $resultLimit;

    public function __construct()
    {
        $this->fieldName = getModuleConfig('settings.field_name', 'Search');
        $this->resultLimit = getModuleConfig('settings.result_limit', 'Search');
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

        foreach ($modules as $module) {
            $moduleSearchItems = getModuleConfig('settings.search', $module);
            if (!$moduleSearchItems) {
                continue;
            }
            
            foreach($moduleSearchItems as $item)
            {
                $searchResult = Search::add($item['model_path'], $item['admin_search_fields'], $item['sort_by_field'])
                                        ->beginWithWildcard()                           //добавить в начало поискового слова %
                                        ->includeModelType()                            //добавит в коллекцию имя модели
                                        ->includeRouteName($item['admin_route'])        //добавит в коллекцию имя роута
                                        ->orderByDesc()
                                        ->search($query);

                $results = $results->merge($searchResult);
            }
        }

        $total_result = $results->count();

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

    protected function validator(&$query)
    {
        $validator = Validator::make([$this->fieldName => $query], $this->getNewRules(), $this->getNewMessages());
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

    protected function getNewRules() : array
    {
        return [
            $this->fieldName => 'required|min:3|max:70'
        ];
    }

    protected function getNewMessages() : array
    {
        return [
            'required' => trans('Search::adminpanel.errors.empty'),
            'min'      => trans('Search::adminpanel.errors.short_word'),
            'max'      => trans('Search::adminpanel.errors.long_word')
        ];
    }
}