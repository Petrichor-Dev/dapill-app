<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'Panglima', 'guard_name' => 'web']);
        // Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'Mayor', 'guard_name' => 'web']);
        Role::create(['name' => 'Jendral', 'guard_name' => 'web']);
        Role::create(['name' => 'Kapten', 'guard_name' => 'web']);
        Role::create(['name' => 'none', 'guard_name' => 'web']);
        $permissions = Permission::get()->toArray();
        $role->givePermissionTo($permissions);
    }
}
