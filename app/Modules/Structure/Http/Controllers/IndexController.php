<?php

namespace App\Modules\Structure\Http\Controllers;

use URL;
use Route;
use Illuminate\Http\Request;
use App\Modules\Structure\Models\Structure;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public function getModel()
    {
        return new Structure();
    }

    public function index()
    {
        $page = getPage();

        return view('Structure::index', compact('page'));
    }
}