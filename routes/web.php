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

// ADMIN
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\MerchandiseAdminController;
use App\Http\Controllers\Admin\ApplicationsController;


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

    Route::post('forgot-password', [
        MemberPasswordController::class,
        'sendForgotPasswordLink'
    ])->name('member.password.forgot.submit');

    Route::middleware('member')->group(function () {
        Route::get('profile', [MemberController::class, 'profile'])->name('member.profile');
        Route::get('qr', [MemberController::class, 'qr'])->name('member.qr');
        Route::post('update-photo', [MemberController::class, 'updatePhoto'])->name('member.update.photo');
        Route::post('update', [MemberController::class, 'update'])->name('member.update');
        Route::post('logout', [MemberLogoutController::class, 'logout'])->name('member.logout');
    });
});



// ADMIN ROUTES
Route::prefix('admin')->group(function () {

    // Admin Auth
    Route::get('login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store'])->name('admin.login.submit');
    Route::post('logout', [LogoutController::class, 'logout'])->name('admin.logout');

    // Admin Middleware
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Admin News
        Route::prefix('news')->group(function () {
            Route::get('/', [NewsAdminController::class, 'index'])->name('admin.news.index');
            Route::get('create', [NewsAdminController::class, 'create'])->name('admin.news.create');
            Route::post('/', [NewsAdminController::class, 'store'])->name('admin.news.store');
            Route::get('{id}/edit', [NewsAdminController::class, 'edit'])->name('admin.news.edit');
            Route::put('{id}', [NewsAdminController::class, 'update'])->name('admin.news.update');
            Route::delete('{id}', [NewsAdminController::class, 'destroy'])->name('admin.news.destroy');
            Route::post('{id}/toggle', [NewsAdminController::class, 'toggle'])->name('admin.news.toggle');
        });

        // Admin Applications
        Route::prefix('applications')->group(function () {
            Route::get('/', [ApplicationsController::class, 'index'])->name('admin.applications.index');
            Route::get('{id}', [ApplicationsController::class, 'show'])->name('admin.applications.show');
            Route::post('{id}/approve', [ApplicationsController::class, 'approve'])->name('admin.applications.approve');
            Route::post('{id}/reject', [ApplicationsController::class, 'reject'])->name('admin.applications.reject');
        });

        // Admin Merchandise
        Route::prefix('merchandise')->group(function () {
            Route::get('/', [MerchandiseAdminController::class, 'index'])->name('admin.merchandise.index');
            Route::get('create', [MerchandiseAdminController::class, 'create'])->name('admin.merchandise.create');
            Route::post('/', [MerchandiseAdminController::class, 'store'])->name('admin.merchandise.store');
            Route::get('{id}/edit', [MerchandiseAdminController::class, 'edit'])->name('admin.merchandise.edit');
            Route::put('{id}', [MerchandiseAdminController::class, 'update'])->name('admin.merchandise.update');
            Route::delete('{id}', [MerchandiseAdminController::class, 'destroy'])->name('admin.merchandise.destroy');
        });
    });
});
