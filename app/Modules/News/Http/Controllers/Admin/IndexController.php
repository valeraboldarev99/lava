<?php

namespace App\Modules\News\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modules\News\Models\News;
use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

use App\Modules\News\Http\ExportAndImport\Export;
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

    public function import()
    {
        return 'import';
    }

    // public function getRules($request, $id = false)
    // {
    //     return [
    //         'image' => 'mimes:png'
    //     ];
    // }
}