<?php

return [
    'menu_items' => [
        [
            'icon'      => 'fa fa-tasks',
            'route'     => 'admin.products.index',
            'group'     => 'main_group',
            'title'     => trans('Products::adminpanel.title'),
            'priority'  => 105,
        ],
        [
            'icon'      => 'fa fa-tasks',
            'route'     => 'admin.products_categories.index',
            'group'     => 'main_group',
            'title'     => trans('Products::adminpanel.products_categories_title'),
            'priority'  => 106,
        ],
    ],
    'localization'      => true,
];