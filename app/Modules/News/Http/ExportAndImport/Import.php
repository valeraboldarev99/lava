<?php

namespace App\Modules\News\Http\ExportAndImport;

use App\Modules\News\Models\News;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
    		// dd(getTableFields('news'));
    	// foreach ($field as getTableFields()) {
    	// }
        return new News([
           'lang'    	=> $row['lang'],
           'title'    	=> $row['title'],
           'date' 		=> $row['date'],
        ]);
    }
}