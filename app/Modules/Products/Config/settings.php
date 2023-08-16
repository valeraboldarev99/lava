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
];