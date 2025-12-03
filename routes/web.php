<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\{
    MedicineController,
    CategoryController,
    SupplierController,
    SaleController
};

Auth::routes();

// ========== HOME ==========
// Route nama "home" cuma satu: /home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// root "/" cukup redirect ke /home
Route::get('/', function () {
    return redirect()->route('home');
});

// ======================
//  Public & Auth Routes
// ======================
Route::get('/update_password', [HomeController::class, 'update_password'])->name('update_password');
Route::patch('/store_password', [HomeController::class, 'store_password'])->name('store_password');

// ======================
//  Admin Dashboard
// ======================
Route::get('/admin/dashboard', [HomeController::class, 'dashboard'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

// ======================
//  Admin Only Routes
// ======================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::get('medicines/report', [MedicineController::class, 'report'])->name('medicines.report');
});

// ======================
//  Admin + Kasir Routes
// ======================
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::resource('medicines', MedicineController::class);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
});

// ======================
//  Public Search Route
// ======================
Route::get('medicines/search', [MedicineController::class, 'search'])->name('medicines.search');
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::get('/suppliers/search', [SupplierController::class, 'search'])->name('suppliers.search');



// ======================
//  Admin + Kasir Routes
// ======================
Route::middleware(['auth', 'role:admin,kasir', 'preventBackHistory'])->group(function () {
    Route::resource('medicines', MedicineController::class);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
});


use Illuminate\Support\Facades\Artisan;

Route::get('/reset-config', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return response('config & cache cleared', 200);
});
