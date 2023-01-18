<?php

namespace App\Modules\News\Http\ExportAndImport;

use App\Modules\News\Models\News;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $tableFields = getTableFields();

        $importArray = [];
        foreach ($tableFields as $field) {
            $importArray[$field] = $row[$field];
        }

        return new News($importArray);
    }
}