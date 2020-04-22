<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['staff', 'sales', 'hr;'];
    }
    
    foreach($roles as $name)
    {
        $role = new \App\Role();
        $role ->name = $name;

    } 
}
