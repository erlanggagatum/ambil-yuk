<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username'     => 'admin',
            'password'     => bcrypt('password'),
            'nickname'     => 'Admin',
            'phone_number' => '000',
            'role'         => 'admin',
        ]);

        $users = [
            ['username' => 'budi',    'nickname' => 'Budi Santoso',  'phone_number' => '08111111111'],
            ['username' => 'sari',    'nickname' => 'Sari Dewi',     'phone_number' => '08222222222'],
            ['username' => 'andi',    'nickname' => 'Andi Pratama',  'phone_number' => '08333333333'],
            ['username' => 'rina',    'nickname' => 'Rina Kusuma',   'phone_number' => '08444444444'],
            ['username' => 'doni',    'nickname' => 'Doni Wijaya',   'phone_number' => '08555555555'],
        ];

        foreach ($users as $user) {
            User::create([
                'username'     => $user['username'],
                'password'     => bcrypt('password'),
                'nickname'     => $user['nickname'],
                'phone_number' => $user['phone_number'],
                'role'         => 'user',
            ]);
        }
    }
}
