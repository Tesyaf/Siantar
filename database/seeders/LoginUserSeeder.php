<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LoginUserSeeder extends Seeder
{
    /**
     * Seed a default user for login.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@example.com',
                'name' => 'Admin Siantar',
                'username' => 'admin',
                'nip' => '1234567890',
                'role' => 'admin',
            ],
            [
                'email' => 'sekretariat@example.com',
                'name' => 'Sekretariat Siantar',
                'username' => 'sekretariat',
                'nip' => '1987654321',
                'role' => 'sekretariat',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'nip' => $user['nip'],
                    'role' => $user['role'],
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
