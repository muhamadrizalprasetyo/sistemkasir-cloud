<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\OwnerController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/track', [TrackController::class, 'index'])->name('track.index');
Route::post('/track/search', [TrackController::class, 'search'])->name('track.search');
Route::get('/init-admin', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed');
    return "Database berhasil di-seed! Silakan login menggunakan:<br>
    - Owner: <b>owner@luxesole.com</b> (password: password)<br>
    - Kasir: <b>kasir@luxesole.com</b> (password: password)";
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('orders', OrderController::class);
    Route::get('/orders/{order}/receipt', [OrderController::class, 'printReceipt'])->name('orders.receipt');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/payment', [OrderController::class, 'updatePayment'])->name('orders.update-payment');
    Route::get('/shift/summary', [ShiftController::class, 'summary'])->name('shift.summary');
    Route::post('/shift/end', [ShiftController::class, 'endShift'])->name('shift.end');

    Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'destroy']);
    Route::resource('customers', CustomerController::class);

    // Master Data (Kategori & Layanan)
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('services', ServiceController::class)->only(['index', 'store', 'update', 'destroy']);

    // Owner monitoring
    Route::get('/owner/shifts', [OwnerController::class, 'index'])->name('owner.shifts');
    Route::get('/owner/shifts/export-csv', [OwnerController::class, 'exportCsv'])->name('owner.shifts.export-csv');
    Route::get('/owner/shifts/export-excel', [OwnerController::class, 'exportExcel'])->name('owner.shifts.export-excel');
});
