<?php

namespace App\Modules\AdminPanel\Http\ViewComposers;

use Illuminate\View\View;

class MenuComposer
{
	public function compose(View $view)
	{
		$modules = modules_all();

		if($modules) {
			foreach ($modules as $module)
			{
				$items = config($module . '.settings.menu_items');
				if($items)
				{
					$menuItems[] = $items;
				}
			}
		}

		$view->with('menuItems', $menuItems);
	}
}