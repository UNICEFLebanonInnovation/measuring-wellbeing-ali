<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

/**
 * First-login flow: a newly created partner or collector receives an
 * email with a signed link, chooses a password and accepts the terms.
 * Uses the password broker's token store, so links expire like resets.
 */
class ProfileSetupController extends Controller
{
    public function show(Request $request, string $token): Response|RedirectResponse
    {
        $user = $this->resolve($request->query('email'), $token);
        if (! $user) {
            return redirect()->route('login')->with('error', __('ui.setup_link_invalid'));
        }

        return Inertia::render('Auth/SetupProfile', [
            'token' => $token,
            'email' => $user->email,
            'name' => $user->isPartner() ? ($user->partner?->name ?? $user->name) : $user->name,
            'role' => $user->getRoleNames()->first(),
        ]);
    }

    public function store(Request $request, string $token): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->letters()->numbers()],
            'agree' => ['accepted'],
        ]);

        $user = $this->resolve($data['email'], $token);
        if (! $user) {
            return redirect()->route('login')->with('error', __('ui.setup_link_invalid'));
        }

        $user->forceFill([
            'password' => $data['password'],
            'is_active' => true,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();
        Password::broker('setup')->deleteToken($user);

        return redirect()->route('login')->with('success', __('ui.setup_completed'));
    }

    private function resolve(?string $email, string $token): ?User
    {
        if (! $email) {
            return null;
        }
        $user = User::where('email', $email)->first();
        if (! $user || ! Password::broker('setup')->tokenExists($user, $token)) {
            return null;
        }

        return $user;
    }
}
