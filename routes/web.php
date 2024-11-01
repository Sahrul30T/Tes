<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('bootstrap5/', function () {
    return view('bootstrap5');
});

// Admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

Route::group(['middleware' => 'auth.admin'], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    Route::get('/admin/products', [AdminController::class, 'showProducts'])->name('admin.products.index');
    Route::get('/admin/products/data', [ProductController::class, 'datatables'])->name('admin.products.datatables');    
    Route::get('/admin/categories/data', [CategoryController::class, 'datatables'])->name('admin.categories.datatables');

    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    
    Route::get('/admin/products/upload', [ProductController::class, 'showUploadForm'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');

    Route::get('/admin/products/{id}/edit', [ProductController::class, 'showEditForm'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');

    Route::get('/admin/categories/create', [CategoryController::class, 'showCategoryUploadForm'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

    Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'showCategoryEditForm'])->name('admin.categories.edit');
    Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');        

    Route::get('/admin/orders', [OrderController::class, 'showOrders'])->name('admin.orders.index');

    Route::get('/new-orders-count', [AdminController::class, 'getNewOrdersCount'])->name('admin.new_orders_count');

    Route::get('/admin/orders/details', [OrderController::class, 'getOrderDetails'])->name('admin.orders.details');
    Route::post('/admin/orders/{id}/approve-payment', [OrderController::class, 'approvePayment'])->name('admin.orders.approvePayment');
    Route::post('/admin/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

// User
Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories');

Route::get('/user/register', [UserController::class, 'register'])->name('user.register'); // Tambahkan rute untuk menampilkan halaman pendaftaran
Route::post('/user/register', [UserController::class, 'store'])->name('user.store'); // Tambahkan rute untuk menangani proses pendaftaran
Route::post('/user/login', [UserController::class, 'login'])->name('user.login');

Route::group(['middleware' => 'auth'], function () {    

    Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout'); // Tambahkan rute untuk logout    
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit'); // Tambahkan rute untuk menampilkan halaman edit
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update'); // Tambahkan rute untuk menangani proses edit
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/count', [CartController::class, 'cartCount'])->name('cart.count');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');

    Route::get('/orders/{orderId}/payment', [OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/orders/{orderId}/upload-payment', [OrderController::class, 'uploadPayment'])->name('orders.uploadPayment');

    Route::get('/orders/transactions', [OrderController::class, 'transactions'])->name('orders.transactions');
    Route::post('/orders/{orderId}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
});
