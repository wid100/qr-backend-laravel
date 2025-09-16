<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'helal@admin.com'], // check by email
            [
                'role_id' => 1,
                'name' => 'Super Admin',
                'country' => 'Bangladesh',
                'phone' => '01792892198',
                'password' => bcrypt('11111111'),
            ]
        );

        // Normal User
        DB::table('users')->updateOrInsert(
            ['email' => 'helal@user.com'],
            [
                'role_id' => 2,
                'name' => 'User',
                'country' => 'Bangladesh',
                'phone' => '01792892198',
                'password' => bcrypt('11111111'),
            ]
        );

        // Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@admin.com'],
            [
                'role_id' => 3,
                'name' => 'Admin',
                'country' => 'Bangladesh',
                'phone' => '01792892198',
                'password' => bcrypt('11111111'),
            ]
        );

        // Block User
        DB::table('users')->updateOrInsert(
            ['email' => 'helal@block.com'],
            [
                'role_id' => 4,
                'name' => 'Block User',
                'country' => 'Bangladesh',
                'phone' => '01792892198',
                'password' => bcrypt('11111111'),
            ]
        );
    }
}
