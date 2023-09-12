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
            'admin_route' => 'admin.products.',
            'user_route' => 'products.index',
            'user_search_content_view' => 'Products::common.search_content',
            'admin_search_fields' => ['title', 'created_at', 'updated_at'],
            'user_search_fields' => ['title'],
            'sort_by_field' => 'position',
        ],
        [
            'model_path' => 'App\Modules\Products\Models\ProductsCategories',
            'admin_route' => 'admin.products_categories.',
            'block_title' => trans('Products::adminpanel.products_categories_title'),
            'user_route' => 'products',
            'admin_search_fields' => ['title', 'created_at', 'updated_at'],
            'user_search_fields' => ['title'],
            'sort_by_field' => 'id',
        ],
    ],
];