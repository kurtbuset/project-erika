<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'kboy',
            'email' => 'kboy@gmail.com',
            'password' => bcrypt('kboykboy'),
            'type' => 0
        ]);
        User::create([
            'name' => 'brownie',
            'email' => 'brownie@gmail.com',
            'password' => bcrypt('brownie'),
            'type' => 0
        ]);
        User::create([
            'name' => 'loys',
            'email' => 'loys@gmail.com',
            'password' => bcrypt('loysloys'),
            'type' => 0
        ]);
    }
}
