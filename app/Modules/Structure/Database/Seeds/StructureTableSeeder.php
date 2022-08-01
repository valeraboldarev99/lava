<?php

namespace App\Modules\Structure\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StructureTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id'            => 1,
            'parent_id'     => null,
            'lang'          => 'ru',
            'depth'         => 0,
            'title'         => 'Главная страница',
            'slug'          => '',
            'module'        => null,
            'redirector'    => 0,
            'redirect_url'  => null,
            'template'      => 'index',
            'active'        => 1,
        ];
        DB::table('structure')->insert($data);
    }
}
