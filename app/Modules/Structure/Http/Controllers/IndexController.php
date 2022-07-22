<?php

namespace App\Modules\Structure\Http\Controllers;

use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Structure\Models\Structure;

class IndexController extends Controller
{
    public function getModel()
    {
        return new Structure();
    }

    public function show()
    {
        $slug = Route::currentRouteName();
        $str = strpos($slug, "/");
        if ($str) {
            $slug = substr($slug, $str + 1, strlen($slug));
        }
        $page = Structure::where('slug', $slug)->first();

        return view('Structure::show', compact('page'));
    }
}