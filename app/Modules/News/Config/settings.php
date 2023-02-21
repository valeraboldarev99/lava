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
    ]
];