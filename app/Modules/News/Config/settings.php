<?php

return [
    'menu_items' => [
        [
            'icon'      => 'fa fa-list',
            'route'     => 'admin.news.index',
            'group'     => 'main_group',
            'title'     => trans('News::adminpanel.title'),
            'priority'  => 100,
        ],
    ],
    'localization'      => true,
    'providers' => [
        'App\Modules\News\Http\ViewComposers\MainComposer' => ['News::main'],
    ],
    'search' => [
        [
            'model_path' => 'App\Modules\News\Models\News',
            'admin_route' => 'admin.news.edit',
            'admin_search_fields' => ['title', 'preview', 'content'],
            'user_search_fields' => ['title'],
            'sort_by_field' => 'position',
        ],
    ],
];