<?php

namespace App\Modules\News\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

use App\Modules\News\Http\ExportAndImport\Export;
use App\Modules\News\Http\ExportAndImport\Import;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends AdminMainController
{
    use FileUploader;

    protected $viewPrefix = 'News';
    protected $routePrefix = 'admin.news.';

    public function getModel()
    {
        return new News();
    }

    public function export()
    {
        return Excel::download(new Export, date('Y_m_d_H_i_s').'_news.csv');
    }

    public function importview()
    {
        return view('News::admin.import');
    }

    public function import(Request $request)
    {
        $request_array = $request->all();
        // dd($request->all(), );
        // return 'import';
        Excel::import(new Import, $request_array['imprt_file']);
        return redirect()->route('admin.news.index')->with('success', 'All good!!!');
    }

    // public function getRules($request, $id = false)
    // {
    //     return [
    //         'image' => 'mimes:png'
    //     ];
    // }
}