<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new user
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'Admin@localhost.com';
        $user->password = bcrypt('12345678');
        $user->save();

        // Create a new user
        $user = new User();
        $user->name = 'User';
        $user->email = 'empleado@localhost.com';
        $user->password = bcrypt('12345678');
        $user->save();
    }
}
