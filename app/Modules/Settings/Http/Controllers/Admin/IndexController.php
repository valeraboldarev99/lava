<?php

namespace App\Modules\Settings\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Settings\Models\Settings;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    protected $viewPrefix = 'Settings';
    protected $routePrefix = 'admin.settings.';

    public function getModel()
    {
        return new Settings();
    }

    public function getRules($request, $id = false)
    {
        return [
            'name' => 'sometimes|required',
            'slug' => 'sometimes|required',
        ];
    }
}