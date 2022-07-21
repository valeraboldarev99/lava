<?php

namespace App\Modules\Structure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Structure\Models\Structure;

class IndexController extends Controller
{
    public function getModel()
    {
        return new Structure();
    }

    public function index()
    {
        return 'structure index page';
    }

    public function __invoke(Structure $page) {
       return view('Structure::show', compact('page'));
   }
}