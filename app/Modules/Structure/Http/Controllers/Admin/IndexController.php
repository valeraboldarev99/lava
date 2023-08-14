<?php

namespace App\Modules\Structure\Http\Controllers\Admin;

use App\Modules\Structure\Models\Structure;
use App\Modules\AdminPanel\Http\Controllers\Other\Position;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    use Position;

    protected $perPage  = 100;
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
        $entities = Structure::with('children')->sortable()->admin()->paginate($this->perPage);

        return view($this->getIndexViewName(), [
            'entities' => $entities
        ]);
    }

    public function create()
    {
        $entity = $this->getModel();
        $parents = Structure::orderBy('position')->orderBy('title')->get();

        return view($this->getFormViewName(), [
            'entity' => $entity,
            'parents' => $this->depthFormat($parents),
        ]);
    }

    public function edit($id)
    {
        $entity = $this->getModel()->findOrFail($id);
        $parents = Structure::orderBy('position')->orderBy('title')->get();

        return view($this->getFormViewName(), [
            'routePrefix'   => $this->routePrefix,
            'entity'        => $entity,
            'parents'       => $this->depthFormat($parents),
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

        return redirect()->back()->with('success', trans('AdminPanel::adminpanel.messages.destroy'));
    }

    protected function after($entity)
    {
        $this->autoPosition($entity);
    }

    private function depthFormat($items)
    {
        foreach($items as $item) {
            if($item->depth == 0)
            {
                $result[$item->id] = $item->title;
            }
            if($item->depth >= 1)
            {
                $result[$item->id] = str_repeat('-', $item->depth) . ' ' . $item->title;
            }
        }
        return $result;
    }

}