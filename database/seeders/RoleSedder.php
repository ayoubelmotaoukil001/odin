<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role ;

class RoleSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles =["admin" ,"viewer","editor"] ;
        foreach($roles as $role)
            {
                Role::create(['name'=>$role]) ;
            }
    }
    
}
