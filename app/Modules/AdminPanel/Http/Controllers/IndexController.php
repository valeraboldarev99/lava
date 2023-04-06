<?php

namespace App\Modules\AdminPanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Helpers\PagesStructure;

class IndexController extends Controller
{
    public    $perPage     = 10;
    protected $viewPrefix  = '';
    protected $routePrefix = '';

    public function __construct() {
        $this->share();
    }

    public function index()
    {
        return view($this->getIndexViewName(), [
            'items' => $this->getModel()->paginate($this->perPage),
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function show($id)
    {
        return view($this->getShowViewName(), [
            'entity'        => $this->getModel()->findOrFail($id),
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function getShowViewName()
    {
        return $this->viewPrefix . '::show';
    }

    public function getIndexViewName()
    {
        return $this->viewPrefix . '::index';
    }

    public function getRules()
    {
        return [];
    }

    protected function getMessages()
    {
        return [];
    }

    protected function getAttributes()
    {
        $attributes = trans('AdminPanel::fields');

        return array_merge($attributes, $this->getCustomAttributes());
    }

    protected function getCustomAttributes() : array
    {
        return [];
    }

    protected function share()
    {
        View::share('page', PagesStructure::getPage());
    }
}