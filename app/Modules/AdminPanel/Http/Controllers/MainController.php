<?php

namespace App\Modules\AdminPanel\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

abstract class MainController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('status');
        $this->share();
    }

    protected $viewPrefix;
    protected $routePrefix;
    // protected $perPage  = 10;

    abstract public function getModel();

    public function index()
    {
        $entities = $this->getModel()->all();

        return view($this->getIndexViewName(), [
            'entities' => $entities
        ]);
    }

    protected function getIndexViewName()
    {
        return $this->viewPrefix . 'admin.index';
    }

    protected function getFormViewName()
    {
        return $this->viewPrefix . 'admin.form';
    }

    protected function share()
    {
        View::share('routePrefix', $this->routePrefix);
    }
}
