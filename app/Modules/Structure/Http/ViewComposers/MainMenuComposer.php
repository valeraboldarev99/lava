<?php

namespace App\Modules\Structure\Http\ViewComposers;

use Illuminate\View\View;
use App\Modules\Structure\Models\Structure;

class MainMenuComposer
{
	public function compose(View $view)
	{
		$pages = Structure::where('active', 1)->get();

		foreach ($pages as $page) {
		    if($page->parent_id == NULL)
		    {
		        $page->slug = $page->slug;
		    }
		    else {
		        $parent = Structure::where('id', $page->parent_id)->first();
		        $page->slug = $parent->slug . '/' . $page->slug;
		    }
		}

		$view->with('items', $pages);
	}
}