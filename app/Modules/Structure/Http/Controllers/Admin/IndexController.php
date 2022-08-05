<?php

namespace App\Modules\Structure\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $entities = Structure::whereNull('parent_id')->with('children')->admin()->paginate($this->perPage);

        return view($this->getIndexViewName(), [
            'entities' => $entities
        ]);
    }

    public function create()
    {
        $entity = $this->getModel();
        $parents = Structure::where('depth', '>', 0)->whereNull('parent_id')->pluck('title', 'id');
        $parents = ['' => trans('Structure::adminpanel.withoutParent')] + $parents->toArray();

        return view($this->getFormViewName(), [
            'entity' => $entity,
            'parents' => $parents,
        ]);
    }

    public function edit($id)
    {
        $entity = $this->getModel()->findOrFail($id);
        $parents = Structure::where('depth', '>', 0)->whereNull('parent_id')->pluck('title', 'id');
        $parents = ['' => trans('Structure::adminpanel.withoutParent')] + $parents->toArray();

        return view($this->getFormViewName(), [
            'routePrefix'   => $this->routePrefix,
            'entity'        => $entity,
            'parents' => $parents,
        ]);
    }

    public function destroy($id)
    {
        $entity = $this->getModel()->find($id);

        if (count($entity->children()->get()) == 0)
        {
            $entity->delete();
        }
        else {
            return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.hasChildren'));
        }

        $this->after($entity);

        return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.destroy'));
    }
}