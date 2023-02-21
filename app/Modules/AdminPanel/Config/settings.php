<?php
return [
	'group' => [
		'title' 	=> trans('AdminPanel::adminpanel.main_group'),
		'name'		=> 'main_group',
		'icon' 		=> 'fa fa-list',
		'priority' 	=> 3,
	],
	'providers'	=> [
		'App\Modules\AdminPanel\Http\ViewComposers\MenuComposer' => ['AdminPanel::common.sidebar'],
		// 'App\Modules\AdminPanel\Http\ViewComposers\MainComposer22' => ['Settings::main', 'Settings::main__mob'], //for example
	],
];
