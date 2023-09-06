<?php

return [
	'menu_items' => [
		[
			'icon' 		=> 'fa fa-tasks',
			'route' 	=> 'admin.structure.index',
			'group'		=> 'main_group',
			'title' 	=> trans('Structure::adminpanel.structure_list'),
			'priority' 	=> 10,
		],
	],
	'localization'		=> true,
	'providers' => [
		'App\Modules\Structure\Http\ViewComposers\MainMenuComposer' => ['Structure::menu_main', 'Structure::menu_mobile'],
		'App\Modules\Structure\Http\ViewComposers\FooterMenuComposer' => ['Structure::menu_footer'],
	],
	'modules' => [
		'users' => trans('Structure::adminpanel.modules.users'),
		'settings' => trans('Structure::adminpanel.modules.settings'),
		'news' => trans('News::adminpanel.title'),
		'products' => trans('Products::adminpanel.title'),
		'contacts' => trans('Contacts::adminpanel.title'),
	],
	'templates' => [
		'layouts.wide'	=> 'Широкий',
		'layouts.inner'	=> 'Стандартный',
	],
    'search' => [
        [
            'model_path' => 'App\Modules\Structure\Models\Structure',
            'admin_route' => 'admin.structure.',
            'user_route' => 'structure.index',
            'admin_search_fields' => ['title', 'slug', 'module', 'content', 'created_at', 'updated_at'],
            'user_search_fields' => ['title', 'slug', 'content'],
            'sort_by_field' => 'position',
        ],
    ],
];