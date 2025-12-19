<?php

// Frontend
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\MerchandiseController;
use App\Http\Controllers\Frontend\MemberController;

// Admin
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\MerchandiseAdminController;
use App\Http\Controllers\Admin\ApplicationsController;


use Illuminate\Support\Facades\Route;

// Frontend

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Member
Route::prefix('member')->group(function () {
    Route::get('/register', [MemberController::class, 'create']);
    Route::post('/register', [MemberController::class, 'store']);
    Route::get('profile', fn() => view('frontend.member.profile'));
    Route::get('qr', fn() => view('frontend.member.qr'));
    Route::post('update', fn() => view('frontend.member.profile'));
});

// Merchandise
Route::prefix('merchandise')->group(function () {
    Route::get('/', [MerchandiseController::class, 'index'])
        ->name('merchandise.index');

    Route::get('{slug}', [MerchandiseController::class, 'show'])
        ->name('merchandise.show');
});

// Admin
Route::prefix('admin')->group(function () {

    // Auth
    Route::get('login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);
    Route::post('logout', [LogoutController::class, 'logout']);

    // Dashboard
    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::prefix('news')->group(function () {
            Route::get('/', [NewsAdminController::class, 'index'])->name('admin.news.index');
            Route::get('create', [NewsAdminController::class, 'create'])->name('admin.news.create');
            Route::post('/', [NewsAdminController::class, 'store'])->name('admin.news.store');
            Route::get('{id}/edit', [NewsAdminController::class, 'edit'])->name('admin.news.edit');
            Route::put('{id}', [NewsAdminController::class, 'update'])->name('admin.news.update');
            Route::delete('{id}', [NewsAdminController::class, 'destroy'])->name('admin.news.destroy');
            Route::post('{id}/toggle', [NewsAdminController::class, 'toggle'])->name('admin.news.toggle');
        });

        // Application
        Route::prefix('applications')->group(function () {
            Route::get('/', [ApplicationsController::class, 'index'])->name('admin.applications.index');
            Route::get('{id}', [ApplicationsController::class, 'show'])->name('admin.applications.show');
            Route::post('{id}/approve', [ApplicationsController::class, 'approve'])->name('admin.applications.approve');
            Route::post('{id}/reject', [ApplicationsController::class, 'reject'])->name('admin.applications.reject');
        });

        // Merchandise
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

