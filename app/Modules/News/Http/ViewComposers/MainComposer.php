<?php

namespace App\Modules\News\Http\ViewComposers;

use Illuminate\View\View;
use App\Modules\News\Models\News;

class MainComposer
{
    public function compose(View $view)
    {
        $items = News::get();

        $view->with('items', $items);
    }
}