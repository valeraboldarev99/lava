<?php

namespace App\Modules\Structure\Http\ViewComposers;

use Illuminate\View\View;
use App\Helpers\PagesStructure;

class MainMenuComposer
{
	public function compose(View $view)
	{
		$pages = PagesStructure::getMainMenu();

		$view->with('items', $pages);
	}
}