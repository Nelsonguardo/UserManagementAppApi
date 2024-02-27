<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'email' => 'admin@example.com',
            'name' => 'Administrator',
            'last_name' => 'User',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_first_time' => true,
            'mobile' => '1234567890',
            'id_number' => '12345678901',
            'date_of_birth' => '1990-01-01',
            'city_code' =>'30001',
            'city_id' => '6',
            'country_id' => '57',
            'department_id' => '601',
        ]);
        
    }
}
