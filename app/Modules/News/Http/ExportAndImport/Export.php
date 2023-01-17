<?php

namespace App\Modules\News\Http\ExportAndImport;

use App\Modules\News\Models\News;
use Maatwebsite\Excel\Concerns\FromCollection;

class Export implements FromCollection
{
    public function collection()
    {
        return News::all();
    }
}