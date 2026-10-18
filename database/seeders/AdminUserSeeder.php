<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Creates the first administrator from environment variables so no
 * password is ever committed. Skipped when the variables are not set or
 * the user already exists.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SDQ_ADMIN_EMAIL');
        $password = env('SDQ_ADMIN_PASSWORD');
        if (! $email || ! $password) {
            $this->command?->warn('SDQ_ADMIN_EMAIL / SDQ_ADMIN_PASSWORD not set; no admin user created.');

            return;
        }
        if (User::where('email', $email)->exists()) {
            return;
        }
        $user = User::create([
            'firstname' => env('SDQ_ADMIN_FIRSTNAME', 'UNICEF'),
            'lastname' => env('SDQ_ADMIN_LASTNAME', 'Admin'),
            'email' => $email,
            'password' => $password,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $user->assignRole(User::ROLE_ADMIN);
        $this->command?->info("Admin user {$email} created.");
    }
}
