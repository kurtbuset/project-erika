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
            'name' => 'teacher2',
            'email' => 'teacher2@gmail.com',
            'password' => bcrypt('teacher2'),
            'type' => 1
        ]);
    }
}
