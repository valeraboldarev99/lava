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
];