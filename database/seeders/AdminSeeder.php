<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        if (!User::query()->whereRole(User::ADMIN)->count()) {
            User::query()->create([
                'f_name' => 'فرید',
                'l_name' => 'شیشه بری',
                'email' => 'faridnewepc78@gmail.com',
                'password' => bcrypt('1234f01234'),
                'role' => User::ADMIN
            ]);
        } else {
            $this->command->warn('Admin has already been created');
        }
    }
}
