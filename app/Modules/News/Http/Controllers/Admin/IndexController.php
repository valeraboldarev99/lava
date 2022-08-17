<?php

namespace App\Modules\News\Http\Controllers\Admin;

use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    protected $viewPrefix = 'News';
    protected $routePrefix = 'admin.news.';

    public function getModel()
    {
        return new News();
    }
}