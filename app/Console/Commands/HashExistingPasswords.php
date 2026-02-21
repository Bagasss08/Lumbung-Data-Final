<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashExistingPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hash-existing-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hash existing plain text passwords in the users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for users with plain text passwords...');

        // Get users where password does not start with bcrypt hash prefix ($2y$)
        $users = DB::table('users')->where('password', 'not like', '$2y$%')->get();

        if ($users->isEmpty()) {
            $this->info('No users with plain text passwords found.');
            return;
        }

        $this->info("Found {$users->count()} users with plain text passwords. Hashing them now...");

        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['password' => Hash::make($user->password)]);
        }

        $this->info('All plain text passwords have been hashed successfully.');
    }
}
