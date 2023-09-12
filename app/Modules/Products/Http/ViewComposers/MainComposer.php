<?php

namespace App\Modules\Products\Http\ViewComposers;

use Illuminate\View\View;
use App\Modules\Products\Models\Products;

class MainComposer
{
    public function compose(View $view)
    {
        $items = Products::items()->whereNotNull('image')->limit(8)->get();

        $view->with('items', $items);
    }
}