<?php

namespace App\Modules\Structure\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use App\Modules\Structure\Models\Structure;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    protected $viewPrefix = 'Structure';
    protected $routePrefix = 'admin.structure.';

    public function getModel()
    {
        return new Structure();
    }

    public function getRules($request, $id = false)
    {
        return [
            'name' => 'sometimes|required',
            'slug' => 'sometimes|required',
        ];
    }

    public function index()
    {
        $entities = Structure::whereNull('parent_id')->with('children')->paginate($this->perPage);

        return view($this->getIndexViewName(), [
            'entities' => $entities
        ]);
    }

    public function create()
    {
        $entity = $this->getModel();
        $parents = Structure::whereNull('parent_id')->get();

        return view($this->getFormViewName(), [
            'entity' => $entity,
            'parents' => $parents,
        ]);
    }

    public function edit($id)
    {
        $entity = $this->getModel()->findOrFail($id);
        $parents = Structure::whereNull('parent_id')->pluck('title', 'id');
// dd($parents);

        return view($this->getFormViewName(), [
            'routePrefix'   => $this->routePrefix,
            'entity'        => $entity,
            'parents' => $parents,
        ]);
    }
}