<?php

namespace App\Modules\AdminPanel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public    $perPage     = 10;
    protected $viewPrefix  = '';
    protected $routePrefix = '';

    // abstract public function getModel();

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

    public function getRules($request, $id = false)
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
}