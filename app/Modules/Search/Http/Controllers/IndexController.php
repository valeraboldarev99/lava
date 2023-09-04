<?php

namespace App\Modules\Search\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Search\Models\Search;
use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public $perPage = 2;
    protected $fieldName;

    public function __construct()
    {
        $this->fieldName = getModuleConfig('settings.field_name', 'Search');
    }

    public function search(Request $request)
    {
        $query = (string)$request->input($this->fieldName); // Получаем строку запроса из формы поиска
        
        //validate

        $modules = modules_collect();
        $results = collect();
        $total   = 0;

        foreach ($modules as $module) {
            $moduleSearchItems = getModuleConfig('settings.search', $module);
            if (!$moduleSearchItems) {
                continue;
            }
            
            foreach($moduleSearchItems as $item)
            {
                $searchResult = Search::add($item['model_path'], $item['admin_search_fields'], $item['sort_by_field'])
                                        ->beginWithWildcard()       //добавить в начало поискового слова %
                                        ->includeModelType()        //добавит в коллекцию имя модели
                                        ->includeRouteName($item['admin_route'])        //добавит в коллекцию имя модели
                                        ->orderByDesc()
                                        ->search($query);

                $results = $results->merge($searchResult);
            }
        }

        return view('Search::admin.search_results',[
            'results' => $results,
            'total' => $results->count(),
        ]);
    }
}