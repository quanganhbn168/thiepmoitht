<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'quanganhadmin@thtmedia.com.vn'],
            [
                'name' => 'Quang Anh Admin',
                'email' => 'quanganhadmin@thtmedia.com.vn',
                'password' => Hash::make('admin123@'),
                'role' => 'admin',
            ]
        );
    }
}
