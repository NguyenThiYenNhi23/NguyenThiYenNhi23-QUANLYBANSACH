<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => null,
            'password' => '123456',
            'role' => 'admin',
        ]);

        $user->trang_thai = true;
        $user->save();
    }
}