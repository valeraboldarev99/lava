<?php

namespace App\Modules\News\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modules\News\Models\News;
use Illuminate\Support\Facades\View;
use App\Modules\AdminPanel\Http\Controllers\Other\Position;
use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;
use App\Modules\News\Http\ExportAndImport\Export;
use App\Modules\News\Http\ExportAndImport\Import;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends AdminMainController
{
    use FileUploader, Position;

    protected $viewPrefix = 'News';
    protected $routePrefix = 'admin.news.';
    protected $fileRoutePrefix = 'admin.news_files.';
    protected $imageRoutePrefix = 'admin.news_images.';

    public function getModel()
    {
        return new News();
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

        return redirect()->route('admin.news.index')->withStatus(trans('AdminPanel::adminpanel.import_success'));
    }

    protected function share()
    {
        View::share('routePrefix', $this->routePrefix);
        View::share('fileRoutePrefix', $this->fileRoutePrefix);
        View::share('imageRoutePrefix', $this->imageRoutePrefix);
        View::share('model_name', class_basename($this->getModel()));
    }

    // public function getRules($request, $id = false)
    // {
    //     return [
    //         // 'image' => 'mimes:png'
    //     ];
    // }
}