<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    protected $signature = 'users:hash-passwords';
    protected $description = 'Hash plain text passwords for all users';

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (!Hash::needsRehash($user->password)) {
                continue; // Skip already hashed passwords
            }

            $user->password = Hash::make($user->password);
            $user->save();
            $this->info("Hashed password for user: {$user->email}");
        }
    }
}
