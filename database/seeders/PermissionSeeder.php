<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayOfPermissionNames = [
            'lihat-kecamatan', 'tambah-kecamatan', 'edit-kecamatan', 'hapus-kecamatan',
            'lihat-desa', 'tambah-desa', 'edit-desa', 'hapus-desa',
            'lihat-tps', 'tambah-tps', 'edit-tps', 'hapus-tps',
            'lihat-pemilih', 'tambah-pemilih', 'edit-pemilih', 'hapus-pemilih',
            'lihat-leader', 'tambah-leader', 'edit-leader', 'hapus-leader',
            'lihat-dpt', 'tambah-dpt', 'edit-dpt', 'hapus-dpt',
            'lihat-role', 'tambah-role', 'edit-role', 'hapus-role',
            'lihat-user', 'tambah-user', 'edit-user', 'hapus-user',
            'lihat-dashboard', 
        ];

        $role = Role::first();
        foreach($arrayOfPermissionNames as $permission){
            $permission = Permission::create(['name' => $permission, 'guard_name' => 'web']);
            $role->givePermissionTo($permission);
        }
    }
}
