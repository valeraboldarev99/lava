<?php

namespace App\Modules\Structure\Http\ViewComposers;

use Illuminate\View\View;
use App\Helpers\PagesStructure;

class FooterMenuComposer
{
	public function compose(View $view)
	{
		$pages = PagesStructure::getFooterMenu();

		$view->with('items', $pages);
	}
}