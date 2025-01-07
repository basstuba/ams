<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminadmin'),
            'role' => 'admin',
            'number' => '00000',
            'department' => '無し'
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '仮野名前',
            'email' => 'fdsa@fdsa.com',
            'password' => Hash::make('fdsafdsa'),
            'role' => '社員',
            'number' => '00001',
            'department' => '総務部'
        ];
        DB::table('users')->insert($param);
    }
}
