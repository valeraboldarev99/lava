<?php

namespace App\Modules\Structure\Http\ViewComposers;

use Illuminate\View\View;
use App\Modules\Structure\Models\Structure;

class MainMenuComposer
{
	public function compose(View $view)
	{
		$pages = Structure::getPagesRoutes();

		$view->with('items', $pages);
	}
}