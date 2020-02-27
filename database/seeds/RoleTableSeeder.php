<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleName = array('super admin','admin','department manager','office of general manager');
        for($i=0;$i<count($roleName);$i++){
            DB::table('roles')->insert([
                'name'=>$roleName[$i],
            ]);
        }
        $departmentName = array('Corporate Planning Department','Office of General Manager','Technical Service Department');
        for($i=0;$i<count($departmentName);$i++){
            DB::table('departments')->insert([
                'name'=>$departmentName[$i],
            ]);
        }
    }
}
