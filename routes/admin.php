<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
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

            // Project
            Route::get('projects', [ProjectController::class, 'index'])->name('projects');
            // Route::get('projects/create', ProjectForm::class)->name('projects.create');
            // Route::get('projects/{id}/edit', ProjectForm::class)->name('projects.edit');

            // Property
            // Route::get('properties', PropertyList::class)->name('properties');
            // Route::get('properties/create', PropertyForm::class)->name('properties.create');
            // Route::get('properties/{id}/edit', PropertyForm::class)->name('properties.edit');
        });
    });
