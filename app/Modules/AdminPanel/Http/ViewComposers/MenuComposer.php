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
				$group = config($module . '.settings.group');
				if (isset($group)) {
					$groups[] = $group;
				}
				$items = config($module . '.settings.menu_items');
				if(isset($items))
				{
					foreach ($items as $item) {
						$newItems[] = $item;
					}
				}
			}
		}
		else {
			dd('Not found modules');
		}

		if (empty($groups)) 	{ dd('Not found groups'); }
		if (empty($newItems)) 	{ dd('Not found newItems'); }

		$newItems = collect($newItems)->sortBy('priority')->toArray();
		$groups = collect($groups)->sortBy('priority')->toArray();

		foreach ($groups as $group) {
			foreach ($newItems as $item) {
				if(empty($item['group']) || $item['group'] == '')
				{
					$item['group'] = 'main_group';
				}
				if($group['name'] == $item['group'])
				{
					$group['items'][] = $item;
				}
			}
			if(isset($group['items']) && !empty($group['items']))
			{
				$menuItems[] = $group;
			}
		}

		$view->with('items', $menuItems);
	}
}