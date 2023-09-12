<?php

namespace App\Modules\News\Http\Controllers;

use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public    $perPage     = 2;
    protected $viewPrefix = 'News';

    public function getModel()
    {
        return new News();
    }
}