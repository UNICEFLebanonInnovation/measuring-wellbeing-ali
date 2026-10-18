<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string', 'max:100'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (! $user || $user->password === null || ! Hash::check($data['password'], $user->password)) {
            return $this->error(__('auth.failed'), 401);
        }
        if (! $user->is_active) {
            return $this->error(__('ui.account_inactive'), 401);
        }
        if (! $user->hasAnyRole([User::ROLE_COLLECTOR, User::ROLE_PARTNER])) {
            return $this->error('Only collector and partner accounts can use the mobile API.', 403);
        }

        $token = $user->createToken($data['device_name'])->plainTextToken;

        return $this->success([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserProfileResource($user),
        ], 'Welcome! '.$user->firstname);
    }

    public function me(Request $request): JsonResponse
    {
        return $this->success(new UserProfileResource($request->user()));
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return $this->success(null, 'Logged out');
    }
}
