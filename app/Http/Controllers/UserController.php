<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Accounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

/** Administrator (UNICEF) accounts. */
class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $admins = User::role(User::ROLE_ADMIN)->orderBy('firstname')->get()
            ->map(fn (User $u) => [
                'id' => $u->id, 'name' => $u->name, 'email' => $u->email, 'phone' => $u->phone,
                'is_active' => (bool) $u->is_active, 'last_login' => null, 'is_me' => $u->id === $request->user()->id,
            ]);

        return Inertia::render('Users/Index', ['admins' => $admins]);
    }

    public function create(): Response
    {
        return Inertia::render('Users/Form', ['user' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);
        Accounts::invite($data, User::ROLE_ADMIN);

        return redirect()->route('users.index')->with('success', __('ui.admin_created'));
    }

    public function edit(User $user): Response
    {
        abort_unless($user->isAdmin(), 404);

        return Inertia::render('Users/Form', ['user' => [
            'id' => $user->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname,
            'email' => $user->email, 'phone' => $user->phone,
        ]]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isAdmin(), 404);
        $data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);
        $user->update($data);

        return redirect()->route('users.index')->with('success', __('ui.saved'));
    }

    public function flags(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isAdmin(), 404);
        if ($user->id === $request->user()->id) {
            return back()->with('error', __('ui.cannot_deactivate_self'));
        }
        $data = $request->validate(['is_active' => ['sometimes', 'boolean'], 'resend_invite' => ['sometimes', 'boolean']]);
        if (array_key_exists('is_active', $data)) {
            $user->update(['is_active' => $data['is_active']]);
        }
        if ($request->boolean('resend_invite')) {
            Accounts::sendSetupLink($user, User::ROLE_ADMIN);
        }

        return back()->with('success', __('ui.saved'));
    }
}
