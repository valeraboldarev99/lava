<?php

namespace App\Modules\Structure\Http\ViewComposers;

use Illuminate\View\View;
use App\Helpers\PagesStructure;

class MainMenuComposer
{
	public function compose(View $view)
	{
		$pages = PagesStructure::getPagesRoutes();

		$view->with('items', $pages);
	}
}