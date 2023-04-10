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
                'name' => 'work',
                'email' => 'work.valeriy99@gmail.com',
                'password' => '$2y$10$UP57NXPaIgxrw2lhEi8xYuqqXw.3Jeu5FWJpSi2pq0Y3nEwvwJjMi',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'email' => 'a@a.ru',
                'password' => bcrypt(12345678),
            ],
        ];
        DB::table('users')->insert($data);
    }

}
