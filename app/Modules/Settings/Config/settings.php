<?php

return [
	'menu_items' => [
		[
			'icon' 		=> 'fa fa-tasks',
			'route' 	=> 'admin.settings.index',
			'group'		=> 'system_group',
			'title' 	=> trans('Settings::adminpanel.settings_list'),
			'priority' 	=> 50,
		],
	],

	'localization'		=> true,

    'search' => [
        [
            'model_path' => 'App\Modules\Settings\Models\Settings',
            'admin_route' => 'admin.settings.',
            'admin_search_content_view' => 'Settings::admin.search_content',
            'admin_search_fields' => ['name', 'slug', 'content'],
            'sort_by_field' => 'id',
        ],
    ],
];