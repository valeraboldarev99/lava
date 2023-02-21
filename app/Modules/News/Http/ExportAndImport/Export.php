<?php

namespace App\Modules\News\Http\ExportAndImport;

use App\Modules\News\Models\News;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export implements FromCollection, WithHeadings
{
    public function collection()
    {
        return News::all();
    }

    public function headings(): array
    {
        return getTableFields();
    }
}