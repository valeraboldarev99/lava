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
];