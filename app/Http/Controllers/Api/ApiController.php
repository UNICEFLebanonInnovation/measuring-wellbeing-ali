<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    protected function success(mixed $data, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $data, 'message' => $message], $status);
    }

    protected function error(string $message, int $status = 422, mixed $errors = null): JsonResponse
    {
        $body = ['success' => false, 'message' => $message];
        if ($errors !== null) {
            $body['errors'] = $errors;
        }

        return response()->json($body, $status);
    }

    /** Whether the user may read this application (same rule as the web UI). */
    protected function canView(User $user, Application $application): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return Application::visibleTo($user)->whereKey($application->id)->exists();
    }

    /** Whether the user may write pre/post test data for this application. */
    protected function canEdit(User $user, Application $application): bool
    {
        if ($user->is_readonly || ! $user->is_active) {
            return false;
        }
        if ($user->isCollector()) {
            return $application->collector_id === $user->id;
        }
        if ($user->isPartner()) {
            return $application->partner_id === $user->id
                || in_array($application->collector_id, $user->collectorUserIds(), true);
        }

        return false;
    }
}
