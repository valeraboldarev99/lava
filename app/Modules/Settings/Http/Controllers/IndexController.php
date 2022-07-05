<?php

namespace App\Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Settings\Models\Settings;

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