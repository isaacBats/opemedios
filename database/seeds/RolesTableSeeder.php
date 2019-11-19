<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        Role::create(['name' => 'manager', 'guard_name' => 'admin']);
        Role::create(['name' => 'monitor', 'guard_name' => 'admin']);
        Role::create(['name' => 'client']);
    }
}
