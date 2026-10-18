<?php

namespace App\Support;

use App\Models\User;
use App\Notifications\SetupProfile;
use Illuminate\Support\Facades\Password;

final class Accounts
{
    /** Create an inactive account that must set its password through the emailed link. */
    public static function invite(array $attributes, string $role): User
    {
        $user = User::create(array_merge($attributes, ['is_active' => false, 'password' => null]));
        $user->assignRole($role);
        self::sendSetupLink($user, $role);

        return $user;
    }

    public static function sendSetupLink(User $user, ?string $role = null): void
    {
        $token = Password::broker('setup')->createToken($user);
        $user->notify(new SetupProfile($token, $role ?? ($user->getRoleNames()->first() ?? 'user')));
    }
}
