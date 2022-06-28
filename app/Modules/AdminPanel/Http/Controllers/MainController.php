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
    protected $perPage  = 10;

    abstract public function getModel();

    public function index()
    {
        $entities = $this->getModel()->paginate($this->perPage);

        return view($this->getIndexViewName(), [
            'entities' => $entities
        ]);
    }

    public function create()
    {
        $entity = $this->getModel();

        return view($this->getFormViewName(), ['entity' => $entity]);
    }

    public function store(Request $request)
    {
        // $this->validate($request, $this->getRules($request), $this->getMessages(), $this->getAttributes());

        $entity = $this->getModel()->create($request->all());

        $this->after($entity);

        return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.store'));
    }

    public function edit($id)
    {
        return view($this->getFormViewName(), [
            'routePrefix'   => $this->routePrefix,
            'entity'        => $this->getModel()->findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->getRules($request, $id), $this->getMessages(), $this->getAttributes());

        $entity = $this->getModel()->findOrFail($id);
        $entity->update($request->all());

        $this->after($entity);

        return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.update'));
    }

    public function destroy($id)
    {
        $entity = $this->getModel()->find($id);
        $entity->delete();

        $this->after($entity);

        return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.destroy'));
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

    protected function after($entity)
    {
        //
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
