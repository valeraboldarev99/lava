<?php

namespace App\Modules\Settings\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Settings\Models\Settings;
use App\Modules\AdminPanel\Http\Controllers\MainController;

class IndexController extends MainController
{
    protected $viewPrefix = 'Settings::';
    protected $routePrefix = 'admin.settings.';

    public function getModel()
    {
        return new Settings();
    }

    public function getRules($request, $id = false)
    {
        return [
        	'slug' => 'required'
        ];
    }
}