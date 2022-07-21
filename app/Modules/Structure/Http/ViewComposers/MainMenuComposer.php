<?php

namespace App\Modules\Structure\Http\ViewComposers;

use Illuminate\View\View;
use App\Modules\Structure\Models\Structure;

class MainMenuComposer
{
	public function compose(View $view)
	{
		$pages = Structure::where('active', 1)->get();

		$view->with('items', $pages);
	}
}