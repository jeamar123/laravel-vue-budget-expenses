<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SpatieRole;

class UserSeeder extends Seeder
{
    protected const USERS = [
        [
            'id' => ADMIN_ID,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'admin', 
            'role' => 'super_admin',
        ],
        [
            'id' => USER_ID,
            'first_name' => 'Guest',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => 'user',
            'role' => 'user',
        ],
        [
            'id' => SUPER_ADMIN_ID,
            'first_name' => 'Jeamar',
            'last_name' => 'Libres',
            'email' => 'jeamar1234@gmail.com',
            'username' => 'jeamar123',
            'password' => 'jeamar08',
            'role' => 'super_admin',
        ],
    ];

    public function run()
    {
        foreach (self::USERS as $user_details) {
            $user = User::create([
                ...$user_details,
                'password' => Hash::make($user_details['password']),
            ]);
            $user->assignRole(SpatieRole::findByName($user_details['role']));
        }
    }
}
