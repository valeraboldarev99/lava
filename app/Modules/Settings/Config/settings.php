<?php
return [
	'menu_items' => [
		[
			'icon' 		=> 'fa fa-list',
			'route' 	=> 'admin.settings.index',
			'title' 	=> trans('Settings::adminpanel.settings_list'),
			'priority' 	=> 1,
		],
	],
	'providers'	=> [
		// 'App\Modules\AdminPanel\Http\ViewComposers\MenuComposer22' => ['AdminPanel::main'],
		// 'App\Modules\AdminPanel\Http\ViewComposers\MenuComposer33' => ['AdminPanel::common.sidebar2']
		// 'views'			=> ['AdminPanel::common.sidebar'],
		// 'composer_path' => 'App\Modules\AdminPanel\Http\ViewComposers\MenuComposer',
	],
];
