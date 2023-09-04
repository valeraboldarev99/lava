<?php

return [
    'group' => [
		'title' 	=> trans('Products::adminpanel.title'),
		'name'		=> 'products_group',
		'icon' 		=> 'fa fa-archive',
		'priority' 	=> 4,
	],
    'menu_items' => [
        [
            'icon'      => 'fa fa-archive',
            'route'     => 'admin.products.index',
            'group'     => 'products_group',
            'title'     => trans('Products::adminpanel.title'),
            'priority'  => 105,
        ],
        [
            'icon'      => 'fa fa-list-ul',
            'route'     => 'admin.products_categories.index',
            'group'     => 'products_group',
            'title'     => trans('Products::adminpanel.products_categories_title'),
            'priority'  => 106,
        ],
    ],
    'localization'      => true,
    'providers' => [
        'App\Modules\Products\Http\ViewComposers\MainComposer' => ['Products::main'],
    ],
    'search' => [
        [
            'model_path' => 'App\Modules\Products\Models\Products',
            'admin_route' => 'admin.products.edit',
            'user_route' => 'products.index',
            'admin_search_fields' => ['title'],
            'user_search_fields' => ['title'],
            'sort_by_field' => 'position',
        ],
        [
            'model_path' => 'App\Modules\Products\Models\ProductsCategories',
            'admin_route' => 'admin.products_categories.edit',
            'user_route' => 'products.index',
            'admin_search_fields' => ['title'],
            'user_search_fields' => ['title'],
            'sort_by_field' => 'id',
        ],
    ],
];