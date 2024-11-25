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
            'name' => 'bagnot gaming',
            'email' => 'bagnot@gmail.com',
            'password' => bcrypt('bagnot'),
            'type' => 0
        ]);
    }
}
