<?php

namespace App\Modules\Products\Http\Controllers;

use App\Modules\Products\Models\Catigories;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class CatigoriesController extends Controller
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