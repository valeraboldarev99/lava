<?php

namespace App\Modules\Structure\Http\Controllers;

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
        
        if($page->redirector)
        {
            return redirect($page->redirect_url);
        }

        return view('Structure::index');
    }
}