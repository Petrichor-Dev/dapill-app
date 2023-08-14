<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'panglima',
            'email' => 'panglima@email.com',
            'password' => Hash::make('berlin123'),
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('tokyo123'),
        ]);

        DB::table('users')->insert([
            'name' => 'jendral',
            'email' => 'jendral@email.com',
            'password' => Hash::make('palermo123'),
        ]);

        DB::table('users')->insert([
            'name' => 'mayor',
            'email' => 'mayor@email.com',
            'password' => Hash::make('jakarta123'),
        ]);

        DB::table('users')->insert([
            'name' => 'prajurit',
            'email' => 'prajurit@email.com',
            'password' => Hash::make('london123'),
        ]);
    }
}
