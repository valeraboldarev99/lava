<?php
return [
	'menu_items' => [
		[
			'icon' 		=> 'fa fa-users',
			'group'		=> 'system_group',
			'route' 	=> 'admin.users.index',
			'title' 	=> trans('Users::adminpanel.users'),
			'priority' 	=> 30,
		],
	],
	'localization'		=> false,
    'search' => [
        [
            'model_path' => 'App\Modules\Users\Models\Users',
            'admin_route' => 'admin.users.',
            'admin_search_content_view' => 'Users::admin.search_content',
            'admin_search_fields' => ['name', 'email', 'created_at', 'updated_at'],
            'sort_by_field' => 'id',
        ],
    ],
];