<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ProfileSetupController;
use App\Http\Controllers\ChangeDecreaseController;
use App\Http\Controllers\CollectorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('locale/{locale}', LocaleController::class)->name('locale.switch');

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('home');
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->middleware('throttle:10,1')->name('login.store');

    Route::get('forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'email'])->middleware('throttle:5,1')->name('password.email');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'update'])->name('password.update');

    Route::get('setup-profile/{token}', [ProfileSetupController::class, 'show'])->name('profile.setup');
    Route::post('setup-profile/{token}', [ProfileSetupController::class, 'store'])->name('profile.setup.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('dashboard/year', [DashboardController::class, 'setYear'])->name('dashboard.year');

    // Applications (all roles; visibility is scoped in the controller)
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

    Route::middleware('role:partner|collector')->group(function () {
        Route::post('applications', [ApplicationController::class, 'store'])->name('applications.store');
        Route::get('applications/{application}/pre-test', [ApplicationController::class, 'editPreTest'])->name('applications.pre-test');
        Route::put('applications/{application}/pre-test', [ApplicationController::class, 'updatePreTest'])->name('applications.pre-test.update');
        Route::get('applications/{application}/post-test', [ApplicationController::class, 'editPostTest'])->name('applications.post-test');
        Route::put('applications/{application}/post-test', [ApplicationController::class, 'updatePostTest'])->name('applications.post-test.update');
        Route::delete('applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    });

    // Change / decrease follow-up
    Route::get('change-decrease', [ChangeDecreaseController::class, 'index'])->name('change-decrease.index');
    Route::put('change-decrease/{application}', [ChangeDecreaseController::class, 'update'])->middleware('role:partner|admin')->name('change-decrease.update');

    Route::middleware('role:admin|partner')->group(function () {
        Route::get('applications-export', ExportController::class)->name('applications.export');
        Route::put('applications/{application}/collector', [ApplicationController::class, 'transfer'])->name('applications.transfer');

        Route::get('collectors', [CollectorController::class, 'index'])->name('collectors.index');
        Route::get('collectors/create', [CollectorController::class, 'create'])->middleware('role:partner')->name('collectors.create');
        Route::post('collectors', [CollectorController::class, 'store'])->middleware('role:partner')->name('collectors.store');
        Route::get('collectors/{collector}/edit', [CollectorController::class, 'edit'])->name('collectors.edit');
        Route::put('collectors/{collector}', [CollectorController::class, 'update'])->name('collectors.update');
        Route::patch('collectors/{collector}/flags', [CollectorController::class, 'flags'])->name('collectors.flags');
        Route::delete('collectors/{collector}', [CollectorController::class, 'destroy'])->middleware('role:partner')->name('collectors.destroy');

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::get('activity-log', [ReportController::class, 'activityLog'])->name('reports.activity');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('partners', PartnerController::class)->except(['destroy']);
        Route::patch('partners/{partner}/flags', [PartnerController::class, 'flags'])->name('partners.flags');
        Route::delete('partners/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');

        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update']);
        Route::patch('users/{user}/flags', [UserController::class, 'flags'])->name('users.flags');

        Route::resource('statuses', StatusController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
        Route::post('locations/{type}', [LocationController::class, 'store'])->where('type', 'governorate|caza|area')->name('locations.store');
        Route::put('locations/{type}/{id}', [LocationController::class, 'update'])->where('type', 'governorate|caza|area')->name('locations.update');
        Route::delete('locations/{type}/{id}', [LocationController::class, 'destroy'])->where('type', 'governorate|caza|area')->name('locations.destroy');
    });

    // Cascading location lookups used by the forms
    Route::get('lookup/cazas/{governorate}', [LocationController::class, 'cazas'])->name('lookup.cazas');
    Route::get('lookup/areas/{caza}', [LocationController::class, 'areas'])->name('lookup.areas');
});
