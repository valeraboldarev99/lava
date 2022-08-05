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
		'App\Modules\Structure\Http\ViewComposers\MainMenuComposer' => ['Structure::menu_main'],
	],
	'modules' => [
		'users' => trans('Structure::adminpanel.modules.users'),
		'settings' => trans('Structure::adminpanel.modules.settings'),
	],
	'templates' => [
		'layouts.wide'	=> 'Default',
	],
];