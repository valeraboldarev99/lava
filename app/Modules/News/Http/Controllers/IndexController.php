<?php

namespace App\Modules\News\Http\Controllers;

use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public function getModel()
    {
        return new News();
    }

    // public function index()
    // {
    //     return 'index page';
    // }

    public function index()
    {
        return view('News::index', [
            'items' => $this->getModel()->get(),
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function show($id)
    {
        return view('News::show', [
            'entity'        => $this->getModel()->findOrFail($id),
            'routePrefix' => $this->routePrefix
        ]);
    }
}