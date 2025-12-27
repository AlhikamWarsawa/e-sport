<?php

use Illuminate\Support\Facades\Route;

// FRONTEND
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\MerchandiseController;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Frontend\Auth\MemberLoginController;
use App\Http\Controllers\Frontend\Auth\MemberLogoutController;
use App\Http\Controllers\Frontend\Auth\MemberPasswordController;
use App\Http\Controllers\Frontend\MemberVerificationController;

// ADMIN
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\MerchandiseAdminController;
use App\Http\Controllers\Admin\MemberAdminController;
use App\Http\Controllers\Admin\ApplicationsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ActivityLogController;


// FRONTEND ROUTES

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('{slug}', [NewsController::class, 'show'])->name('news.show');
});

// Merchandise
Route::prefix('merchandise')->group(function () {
    Route::get('/', [MerchandiseController::class, 'index'])->name('merchandise.index');
    Route::get('{slug}', [MerchandiseController::class, 'show'])->name('merchandise.show');
});

// MEMBER ROUTES
Route::prefix('member')->group(function () {
    Route::get('register', [MemberController::class, 'create'])->name('member.register');
    Route::post('register', [MemberController::class, 'store'])->name('member.register.submit');

    Route::get('login', [MemberLoginController::class, 'index'])->name('member.login');
    Route::post('login', [MemberLoginController::class, 'store'])->name('member.login.submit');

    Route::get('set-password/{token}', [MemberPasswordController::class, 'index'])->name('member.password.index');
    Route::post('set-password/{token}', [MemberPasswordController::class, 'store'])->name('member.password.store');

    Route::get('forgot-password', function () {
        return view('frontend.member.forgot-password');
    })->name('member.password.forgot');

    Route::post('forgot-password', [MemberPasswordController::class, 'sendForgotPasswordLink'])->name('member.password.forgot.submit');

    Route::get('verify/{token}', [MemberVerificationController::class, 'show'])->name('member.verify');


    Route::middleware('member')->group(function () {
        Route::get('profile', [MemberController::class, 'profile'])->name('member.profile');
        Route::post('update-photo', [MemberController::class, 'updatePhoto'])->name('member.update.photo');
        Route::post('update', [MemberController::class, 'update'])->name('member.update');
        Route::post('logout', [MemberLogoutController::class, 'logout'])->name('member.logout');
    });
});


// ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Auth
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.submit');
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

    // Admin Middleware
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

        // News
        Route::prefix('news')->group(function () {
            Route::get('/', [NewsAdminController::class, 'index'])->name('news.index');
            Route::get('create', [NewsAdminController::class, 'create'])->name('news.create');
            Route::post('/', [NewsAdminController::class, 'store'])->name('news.store');
            Route::get('{id}/edit', [NewsAdminController::class, 'edit'])->name('news.edit');
            Route::put('{id}', [NewsAdminController::class, 'update'])->name('news.update');
            Route::delete('{id}', [NewsAdminController::class, 'destroy'])->name('news.destroy');
            Route::post('{id}/toggle', [NewsAdminController::class, 'toggle'])->name('news.toggle');
        });

        // Applications
        Route::prefix('applications')->group(function () {
            Route::get('/', [ApplicationsController::class, 'index'])->name('applications.index');
            Route::get('{id}', [ApplicationsController::class, 'show'])->name('applications.show');
            Route::post('{id}/approve', [ApplicationsController::class, 'approve'])->name('applications.approve');
            Route::post('{id}/reject', [ApplicationsController::class, 'reject'])->name('applications.reject');
        });

        // Merchandise
        Route::prefix('merchandise')->group(function () {
            Route::get('/', [MerchandiseAdminController::class, 'index'])->name('merchandise.index');
            Route::get('create', [MerchandiseAdminController::class, 'create'])->name('merchandise.create');
            Route::post('/', [MerchandiseAdminController::class, 'store'])->name('merchandise.store');
            Route::get('{id}/edit', [MerchandiseAdminController::class, 'edit'])->name('merchandise.edit');
            Route::put('{id}', [MerchandiseAdminController::class, 'update'])->name('merchandise.update');
            Route::delete('{id}', [MerchandiseAdminController::class, 'destroy'])->name('merchandise.destroy');
        });

        // Members
        Route::prefix('members')->group(function () {
            Route::get('/', [MemberAdminController::class, 'index'])->name('members.index');
            Route::get('{membership_id}', [MemberAdminController::class, 'show'])->name('members.show');
        });
    });
});
