<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('index');
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

        Route::middleware('auth')->group(function () {
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('dashboard', DashboardController::class)->name('dashboard');
        });
    });
