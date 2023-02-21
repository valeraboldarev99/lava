<?php

namespace App\Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Settings\Models\Settings;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public function getModel()
    {
        return new Settings();
    }

    public function index()
    {
        return 'settings index page';
    }
}