<?php

namespace App\Modules\News\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\Other\Position;
use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;
use App\Modules\AdminPanel\Http\Controllers\Other\RelatedEntities;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;
use App\Modules\News\Http\ExportAndImport\Export;
use App\Modules\News\Http\ExportAndImport\Import;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends AdminMainController
{
    use FileUploader, Position, RelatedEntities;

    protected $viewPrefix = 'News';
    protected $routePrefix = 'admin.news.';

    protected $relatedTable = [
        'table' => 'news_related',
        'main_table' => 'news',
        'entity_id' => 'news_id'
    ];

    public function getModel()
    {
        return new News();
    }

    public function edit($id)
    {
        return view($this->getFormViewName(), [
            'routePrefix'   => $this->routePrefix,
            'entity'        => $this->getModel()->findOrFail($id),
            'related_entities' => $this->getEntityRelated($id),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->getRules($request), $this->getMessages(), $this->getAttributes());
        $entity = $this->getModel()->create($request->all());
        
        session(['requestArray' => $request->all()]);
        $this->after($entity);

        return redirect()->route($this->routePrefix . 'edit', $entity->id)->with('success', trans('AdminPanel::adminpanel.messages.store'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->getRules($request, $id), $this->getMessages(), $this->getAttributes());
        $entity = $this->getModel()->findOrFail($id);
        $entity->update($request->all());
        
        session(['requestArray' => $request->all()]);
        $this->after($entity);

        return redirect()->back()->with('success', trans('AdminPanel::adminpanel.messages.update'));
    }

    public function after($entity)
    {
        if (getMethod() == 'store' || getMethod() == 'update') {
            //FileUploader
            $this->upload($entity);
            //RelatedEntities
            $this->editRelatedEntities($entity->id, session('requestArray'));
        }
        if(getMethod() == 'destroy') {
            //FileUploader
            $this->deleteAllFiles($entity);
            //RelatedEntities
            $this->deleteRelated($entity->id);
        }
    }

    public function export()
    {
        return Excel::download(new Export, date('Y_m_d_H_i_s').'_news.csv');
    }

    public function import(Request $request)
    {
        $request_array = $request->all();

        $import = new Import();
        $import->import($request_array['import_file']);

        if($import->failures()->isNotEmpty())
        {
            return back()->withFailures($import->failures());
        }

        return redirect()->route($this->routePrefix . 'index')->withStatus(trans('AdminPanel::adminpanel.import_success'));
    }

    // public function getRules($request, $id = false)
    // {
    //     return [
    //         // 'image' => 'mimes:png'
    //     ];
    // }
}