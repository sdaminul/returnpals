<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\InvoicesController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\PackagesBulkUploadController;
use App\Http\Controllers\Dashboard\PendingController;
use App\Http\Controllers\Dashboard\ReceivedController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\SoldItemsController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('index'))->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/overview', [OverviewController::class, 'index'])->name('overview');
    Route::post('/packages', [OverviewController::class, 'store'])->name('packages.store');
    Route::put('/packages/{package}', [OverviewController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [OverviewController::class, 'destroy'])->name('packages.destroy');

    // Bulk upload (CSV/XLSX)
    Route::post('/packages/bulk/preview', [PackagesBulkUploadController::class, 'preview'])->name('packages.bulk.preview');
    Route::post('/packages/bulk/commit', [PackagesBulkUploadController::class, 'commit'])->name('packages.bulk.commit');

    Route::get('/received', [ReceivedController::class, 'index'])->name('received');
    Route::get('/sold-items', [SoldItemsController::class, 'index'])->name('sold-items');
    Route::get('/item-pending', [PendingController::class, 'index'])->name('item-pending');

    Route::get('/invoices', [InvoicesController::class, 'index'])->name('invoices');
    Route::get('/invoices/{invoice}/download', [InvoicesController::class, 'download'])->name('invoices.download');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// Admin Routes
Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
});
