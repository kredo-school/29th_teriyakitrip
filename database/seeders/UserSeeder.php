<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 特定のユーザーを作成 (Toshimi Tada)
        User::create([
            'username' => 'Toshi12345',
            'email' => 'toshimi@example.com',
            'password' => Hash::make('password'), // パスワードはハッシュ化
            'avatar' => 'images/toshimi.jpg', // public/images/toshimi.jpgに画像を配置
        ]);
    }
}
