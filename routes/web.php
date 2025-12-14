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
    Route::get('profile', fn () => view('frontend.member.profile'));
    Route::get('qr', fn () => view('frontend.member.qr'));
    Route::post('update', fn () => view('frontend.member.profile'));
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
    });

    // News
    Route::prefix('news')->group(function () {
        Route::get('/', fn () => view('admin.news.index'));
        Route::get('create', fn () => view('admin.news.create'));
        Route::post('/', fn () => view('admin.news.index'));
        Route::get('{id}/edit', fn () => view('admin.news.edit'));
        Route::put('{id}', fn () => view('admin.news.edit'));
        Route::delete('{id}', fn () => view('admin.news.index'));
        Route::post('{id}/toggle', fn () => view('admin.news.index'));
    });

    // Application
    Route::prefix('applications')->group(function () {
        Route::get('/', fn () => view('admin.applications.index'));
        Route::get('{id}', fn () => view('admin.applications.show'));
        Route::post('{id}/approve', fn () => view('admin.applications.show'));
        Route::post('{id}/reject', fn () => view('admin.applications.show'));
    });

    // Merchandise
    Route::prefix('merchandise')->group(function () {
        Route::get('/', fn () => view('admin.merchandise.index'));
        Route::get('create', fn () => view('admin.merchandise.create'));
        Route::post('/', fn () => view('admin.merchandise.index'));
        Route::get('{id}/edit', fn () => view('admin.merchandise.edit'));
        Route::put('{id}', fn () => view('admin.merchandise.edit'));
        Route::delete('{id}', fn () => view('admin.merchandise.index'));
    });
});
