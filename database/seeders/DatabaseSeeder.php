<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Users\Database\seeds\RolesTableSeeder;
use App\Modules\Users\Database\seeds\UsersTableSeeder;
use App\Modules\Users\Database\seeds\UserRolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
    }
}