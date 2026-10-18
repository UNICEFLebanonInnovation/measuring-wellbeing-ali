<?php

use App\Http\Controllers\Api\Legacy\LegacyApplicationController;
use App\Http\Controllers\Api\Legacy\LegacyAuthController;
use App\Http\Controllers\Api\Legacy\LegacyLocationController;
use App\Http\Controllers\Api\V1\ApplicationController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ReferenceController;
use App\Http\Controllers\Api\V1\SyncController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json(['ok' => true, 'time' => now()->toIso8601String()]));

/*
|--------------------------------------------------------------------------
| API v1 (Sanctum bearer tokens) - used by the new mobile application
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth/me', [AuthController::class, 'me'])->name('auth.me');

        Route::get('reference', ReferenceController::class)->name('reference');

        Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::post('applications', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::put('applications/{application}/pre-test', [ApplicationController::class, 'preTest'])->name('applications.pre-test');
        Route::put('applications/{application}/post-test', [ApplicationController::class, 'postTest'])->name('applications.post-test');

        Route::post('sync', SyncController::class)->name('sync');
    });
});

/*
|--------------------------------------------------------------------------
| Legacy API - exact paths and shapes used by the Android app in the field
|--------------------------------------------------------------------------
*/
Route::any('login', [LegacyAuthController::class, 'login'])->middleware('throttle:10,1');
Route::any('logout', [LegacyAuthController::class, 'logout']);
Route::any('forgot-password', [LegacyAuthController::class, 'forgotPassword'])->middleware('throttle:5,1');
Route::any('get-all-locations', [LegacyLocationController::class, 'all']);

Route::middleware('legacy_api_token')->group(function () {
    Route::any('create-application', [LegacyApplicationController::class, 'create']);
    Route::any('save-pre-test-application', [LegacyApplicationController::class, 'savePreTest']);
    Route::any('submit-pre-test-application', [LegacyApplicationController::class, 'submitPreTest']);
    Route::any('save-post-test-application', [LegacyApplicationController::class, 'savePostTest']);
    Route::any('submit-post-test-application', [LegacyApplicationController::class, 'submitPostTest']);
    Route::any('get-application', [LegacyApplicationController::class, 'list']);
    Route::any('pre-test-application', [LegacyApplicationController::class, 'preTest']);
    Route::any('post-test-application', [LegacyApplicationController::class, 'postTest']);
    Route::any('view-application', [LegacyApplicationController::class, 'view']);

    Route::any('get-gouvernate', [LegacyLocationController::class, 'governorates']);
    Route::any('get-caza', [LegacyLocationController::class, 'cazas']);
    Route::any('get-area', [LegacyLocationController::class, 'areas']);
    Route::any('get-status', [LegacyLocationController::class, 'statuses']);
});
