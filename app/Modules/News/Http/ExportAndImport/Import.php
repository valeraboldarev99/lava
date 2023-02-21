<?php

namespace App\Modules\News\Http\ExportAndImport;

use App\Modules\News\Models\News;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class Import implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        $tableFields = getTableFields();

        $importArray = [];
        foreach ($tableFields as $field) {
            $importArray[$field] = $row[$field];
        }

        return new News($importArray);
    }

    public function rules(): array
    {
        return [
            '*.title' => 'required',
        ];
    }
}