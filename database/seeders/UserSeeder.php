<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'super admin',
            'email' => 'superadmin@email.com',
            'password' => Hash::make('berlin123'),
            'jabatan_id' => 1
        ]);

        // User::create([
        //     'name' => 'panglima', 
        //     'email' => 'panglima@email.com',
        //     'password' => Hash::make('berlin123'),
        // ]);

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@email.com',
        //     'password' => Hash::make('tokyo123'),
        // ]);

        // User::create([
        //     'name' => 'jendral',
        //     'email' => 'jendral@email.com',
        //     'password' => Hash::make('palermo123'),
        // ]);

        // User::create([
        //     'name' => 'mayor',
        //     'email' => 'mayor@email.com',
        //     'password' => Hash::make('jakarta123'),
        // ]);

        // User::create([
        //     'name' => 'kapten',
        //     'email' => 'kapten@email.com',
        //     'password' => Hash::make('london123'),
        // ]);

        $superAdmin->assignRole('Super Admin');
    }
}
