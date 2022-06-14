<?php

namespace App\Modules\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**R
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'user',
            ],
            [
                'name' => 'disabled',
            ],
        ];
        DB::table('roles')->insert($data);
    }
}
