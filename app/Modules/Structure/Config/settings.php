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
	'providers' => [
		'App\Modules\Structure\Http\ViewComposers\MainMenuComposer' => ['Structure::menu_main'],
	],
];