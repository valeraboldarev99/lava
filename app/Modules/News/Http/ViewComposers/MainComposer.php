<?php

namespace App\Modules\News\Http\ViewComposers;

use Illuminate\View\View;
use App\Modules\News\Models\News;

class MainComposer
{
    public function compose(View $view)
    {
        $items = News::items()->whereNotNull('image')->limit(4)->get();

        $view->with('items', $items);
    }
}