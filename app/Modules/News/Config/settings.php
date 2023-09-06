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
            'user_route' => 'news.index',
            'admin_route' => 'admin.news.',
            'block_title' => trans('News::index.title'),
            // 'user_search_content_view' => 'News::search_content',
            // 'admin_search_content_view' => 'News::admin.search_content',
            'admin_search_fields' => ['title', 'date', 'preview', 'content', 'created_at', 'updated_at'],
            'user_search_fields' => ['title'],
            'sort_by_field' => 'position',
        ],
    ],
];