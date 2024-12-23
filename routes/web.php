<?php
// filepath: /e:/CSE485Web/laravel/Sales_Management/routes/web.php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\CustormerController;

Route::get("/", [ProductController::class, "home"])->name('home');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}/delete', [ProductController::class, 'confirmDelete'])->name('products.delete');

});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index'); 
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create'); 
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit'); 
    Route::put('/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('orders.destroy'); 
    Route::get('/customers/{customer}/orders/history', [OrderController::class, 'customerOrderHistory'])->name('orders.history');

});
Route::prefix('order_details')->group(function () {
    Route::get('/{order}', [OrderDetailController::class, 'index'])->name('orderdetails.index');
    Route::get('/create', [OrderDetailController::class, 'create'])->name('orderdetails.create');
    Route::post('/store', [OrderDetailController::class, 'store'])->name('orderdetails.store');
    Route::get('/{id}/edit', [OrderDetailController::class, 'edit'])->name('orderdetails.edit');
    Route::put('/{id}', [OrderDetailController::class, 'update'])->name('orderdetails.update');
    Route::delete('/{id}', [OrderDetailController::class, 'destroy'])->name('orderdetails.destroy');
});

Route::prefix('customers')->group(function () {
    Route::get('/', [CustormerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustormerController::class, 'create'])->name('customers.create');
    Route::post('/store', [CustormerController::class, 'store'])->name('customers.store');
    Route::get('/{id}/edit', [CustormerController::class, 'edit'])->name('customers.edit');
    Route::put('/{id}', [CustormerController::class, 'update'])->name('customers.update');
    Route::delete('/{id}', [CustormerController::class, 'destroy'])->name('customers.destroy');
});
