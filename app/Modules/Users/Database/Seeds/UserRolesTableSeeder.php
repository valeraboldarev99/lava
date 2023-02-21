<?php

namespace App\Modules\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => '1',
                'role_id' => '1',
            ],
            [
                'user_id' => '2',
                'role_id' => '2',
            ],
        ];
        DB::table('user_roles')->insert($data);
    }
}
