<?php

use Illuminate\Support\Facades\Route;

// API routes are added by the API work package (v1 under /api/v1 and the
// legacy-compatible routes used by the current Android application).
Route::get('/ping', fn () => response()->json(['ok' => true, 'time' => now()->toIso8601String()]));
