<?php

namespace App\Http\Controllers\Api\Legacy;

use App\Http\Controllers\Api\ApiController;
use App\Models\Application;
use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use App\Support\Accounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * /api/login, /api/logout and /api/forgot-password with the exact response
 * shape expected by the Android app currently in the field.
 */
class LegacyAuthController extends ApiController
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->legacyError('Validation Error.', $validator->errors());
        }

        $user = User::where('email', $request->input('email'))->first();
        if (! $user) {
            return $this->legacyError('User does not exists');
        }
        if (! $user->is_active) {
            return $this->legacyError('Your account is inactive');
        }
        if ($user->password === null || ! Hash::check($request->input('password'), $user->password)) {
            return $this->legacyError('Invalid credentials');
        }

        $collector = Collector::where('user_id', $user->id)->first();
        if (! $collector) {
            return $this->legacyError('Collector not found or unauthorized user');
        }
        $partner = Partner::where('user_id', $collector->partner_id)->first();
        if (! $partner || empty($partner->prefix)) {
            return $this->legacyError('Partner Prefix not added');
        }
        if (empty($collector->prefix)) {
            return $this->legacyError('Collector Prefix not added');
        }

        $user->forceFill(['api_token' => Str::random(50)])->save();

        $data = [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'phone' => $user->phone,
            'zone' => $user->zone,
            'address' => $user->address,
            'fax' => $user->fax,
            'is_active' => $user->is_active ? '1' : '0',
            'email_verified_at' => $user->email_verified_at?->toDateTimeString(),
            'is_readonly' => $user->is_readonly ? '1' : '0',
            'api_token' => $user->api_token,
            'created_at' => $user->created_at?->toDateTimeString(),
            'updated_at' => $user->updated_at?->toDateTimeString(),
            'collector_prefix' => $collector->prefix,
            'partner_prefix' => $partner->prefix,
            'partner_name' => $partner->name,
            'last_increment_no' => Application::withTrashed()->where('collector_id', $user->id)->count(),
            // sdq-12.apk requires these two keys (reporting-year spinner); login fails without them.
            'year' => (string) now()->year,
            'years' => $this->reportingYears($user->id),
        ];

        return $this->success($data, 'Welcome! '.ucfirst((string) $user->firstname));
    }

    /** Years offered by the app's reporting-year spinner: the collector's existing years plus the current one. */
    private function reportingYears(int $collectorUserId): array
    {
        $years = Application::withTrashed()->where('collector_id', $collectorUserId)
            ->whereNotNull('year')->distinct()->orderBy('year')->pluck('year')->map(fn ($y) => (int) $y)->all();
        $years[] = (int) now()->year;

        return array_values(array_unique($years));
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->input('token');
        if ($token) {
            User::where('api_token', $token)->update(['api_token' => null]);
        }

        return $this->success([], 'Logout');
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);
        if ($validator->fails()) {
            return $this->legacyError('Validation Error.', $validator->errors());
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user && $user->is_active) {
            Accounts::sendSetupLink($user);
        }

        // Same answer whether or not the address exists.
        return $this->success([], 'Please check your email to get reset password link');
    }

    private function legacyError(string $message, mixed $data = null, int $status = 404): JsonResponse
    {
        $body = ['success' => false, 'message' => $message];
        if ($data !== null) {
            $body['data'] = $data;
        }

        return response()->json($body, $status);
    }
}
