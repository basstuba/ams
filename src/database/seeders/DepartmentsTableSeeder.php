<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = ['department_name' => '総務部'];
        DB::table('departments')->insert($param);

        $param = ['department_name' => '人事部'];
        DB::table('departments')->insert($param);

        $param = ['department_name' => '経理部'];
        DB::table('departments')->insert($param);

        $param = ['department_name' => '営業部'];
        DB::table('departments')->insert($param);

        $param = ['department_name' => '開発部'];
        DB::table('departments')->insert($param);

        $param = ['department_name' => '無し'];
        DB::table('departments')->insert($param);
    }
}
