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
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'manager', 'guard_name' => 'web']);
        Role::create(['name' => 'monitor', 'guard_name' => 'web']);
        Role::create(['name' => 'client', 'guard_name' => 'web']);
        Role::create(['name' => 'disable', 'guard_name' => 'web']);
    }
}
