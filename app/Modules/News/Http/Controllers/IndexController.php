<?php

namespace App\Modules\News\Http\Controllers;

use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public    $perPage     = 20;
    protected $viewPrefix = 'News';

    public function getModel()
    {
        return new News();
    }

    public function index()
    {
        return view($this->getIndexViewName(), [
            'items' => $this->getModel()->items()->paginate($this->perPage),
            'routePrefix' => $this->routePrefix
        ]);
    }
}