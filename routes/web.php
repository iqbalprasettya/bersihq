<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WhatsAppConfigController;
use App\Http\Controllers\WhatsAppConnectionController;
use App\Http\Controllers\WhatsAppTemplateController;
use Illuminate\Support\Facades\Route;

// Route untuk guest/belum login
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

// Route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Customers
    Route::resource('customers', CustomerController::class);

    // Services
    Route::resource('services', ServiceController::class);

    // Reports
    Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/transactions/export', [ReportController::class, 'exportTransactions'])->name('reports.transactions.export');

    // User Management Routes (Hanya untuk admin)
    Route::prefix('users')->name('users.')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // WhatsApp Bot Routes (Hanya untuk admin)
    Route::prefix('whatsapp')->name('whatsapp.')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
        Route::get('/config', [WhatsAppConfigController::class, 'index'])->name('config');
        Route::post('/config', [WhatsAppConfigController::class, 'update'])->name('config.update');
        Route::get('/connect', [WhatsAppConnectionController::class, 'index'])->name('connect');
        Route::post('/connect/qr', [WhatsAppConnectionController::class, 'getQR'])->name('connect.qr');
        Route::post('/connect/disconnect', [WhatsAppConnectionController::class, 'disconnect'])->name('connect.disconnect');

        // Template Routes
        Route::get('/template', [WhatsAppTemplateController::class, 'index'])->name('template');
        Route::get('/template/{id}/edit', [WhatsAppTemplateController::class, 'edit'])->name('template.edit');
        Route::put('/template/{id}', [WhatsAppTemplateController::class, 'update'])->name('template.update');
        Route::get('/template/{id}/preview', [WhatsAppTemplateController::class, 'preview'])->name('template.preview');
    });
});
