<?php

namespace App\Modules\News\Http\ExportAndImport;

use App\Modules\News\Models\News;
use Maatwebsite\Excel\Concerns\ToModel;

class Import implements ToModel
{
    public function model(array $row)
    {
        return new News([
           'lang'    	=> $row[1],
           'title'    	=> $row[2],
           'date' 		=> $row[3],
        ]);
    }
}