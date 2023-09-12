<?php
return [
	'name' => 'LaVa',									// название cms
	'url' => [
	    'admin_auth'   => 'admin_panel',				//url входа для админа
	    'admin_panel'   => 'admin_panel/main',			// url главной страницы админки
		'admin_prefix' => 'admin',						//префикс url роутов admin/*****
	],
	'admin_prefix' => 'admin.',							//префикс имени роутов admin.*****
	'version' => '1.4.3',								// версия cms
    'indexation' => env('APP_INDEXATION', false)        //индексировать сайт?
];