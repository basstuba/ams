<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        User::factory(50)->create();
        Work::factory(500)->create();
        Rest::factory(500)->create();
    }
}
