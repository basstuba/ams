<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = ['role_name' => '社員'];
        DB::table('roles')->insert($param);

        $param = ['role_name' => '契約社員'];
        DB::table('roles')->insert($param);

        $param = ['role_name' => 'アルバイト'];
        DB::table('roles')->insert($param);
    }
}
