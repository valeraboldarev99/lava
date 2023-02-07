<?php

namespace App\Modules\Products\Http\Controllers;

use App\Modules\Products\Models\Products;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public function getModel()
    {
        return new Products();
    }

    public function index()
    {
        return 'index page';
    }
}