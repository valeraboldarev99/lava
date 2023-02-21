<?php

namespace App\Modules\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'a@a.ru',
                'password' => bcrypt(12345678),
            ],
            [
                'id' => 2,
                'name' => 'user',
                'email' => 'u@u.ru',
                'password' => bcrypt(123),
            ],
        ];
        DB::table('users')->insert($data);
    }

}
