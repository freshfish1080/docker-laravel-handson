<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
// use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoodsCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SalesController;

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

Auth::routes();
// Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/top', [HomeController::class, 'top'])->name('top');
Route::get('/systems', [HomeController::class, 'showSystems'])->name('showSystems');
Route::get('/sales', [HomeController::class, 'showSales'])->name('showSales');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/store', [HomeController::class, 'store'])->name('store');
Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
Route::post('/update', [HomeController::class, 'update'])->name('update');
Route::post('/destroy', [HomeController::class, 'destroy'])->name('destroy');

Route::get('/goods/category/list', [GoodsCategoryController::class, 'list'])->name('goods_category.list');
Route::get('/goods/category/create', [GoodsCategoryController::class, 'create'])->name('goods_category.create');
Route::post('/goods/category/store', [GoodsCategoryController::class, 'store'])->name('goods_category.store');
Route::get('/goods/category/edit/{id}', [GoodsCategoryController::class, 'edit'])->name('goods_category.edit');
Route::post('/goods/category/update', [GoodsCategoryController::class, 'update'])->name('goods_category.update');
Route::post('/goods/category/destroy', [GoodsCategoryController::class, 'destroy'])->name('goods_category.destroy');

Route::get('/customer/list', [CustomerController::class, 'list'])->name('customer.list');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/customer/update', [CustomerController::class, 'update'])->name('customer.update');
Route::post('/customer/destroy', [CustomerController::class, 'destroy'])->name('customer.destroy');

Route::get('/goods/list', [GoodsController::class, 'list'])->name('goods.list');
Route::get('/goods/create', [GoodsController::class, 'create'])->name('goods.create');
Route::post('/goods/store', [GoodsController::class, 'store'])->name('goods.store');
Route::get('/goods/edit/{id}', [GoodsController::class, 'edit'])->name('goods.edit');
Route::post('/goods/update', [GoodsController::class, 'update'])->name('goods.update');
Route::post('/goods/destroy', [GoodsController::class, 'destroy'])->name('goods.destroy');

// カートの中身表示　
Route::get('/cart/list/{id}', [CartController::class, 'listCart'])->name('cart.listCart');
// カートに追加する
Route::post('/cart/add', [CartController::class, 'addCart'])->name('cart.addCart');
// カートの最終確認画面
Route::get('/cart/confirm/{id}', [CartController::class, 'confirmCart'])->name('cart.confirmCart');
// カート内容をデータベースへ反映する
Route::post('/cart/exe', [CartController::class, 'exeCart'])->name('cart.exeCart');
Route::get('/cart/customer/search', [CartController::class, 'searchCustomer'])->name('cart.searchCustomer');
Route::post('/cart/customer/find', [CartController::class, 'findCustomer'])->name('cart.findCustomer');
Route::get('/cart/goods/select/{id}', [CartController::class, 'selectGoods'])->name('cart.selectGoods');
Route::post('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/sales/list', [SalesController::class, 'listSlip'])->name('sales.listSlip');
Route::get('/sales/slip', [SalesController::class, 'searchSlip'])->name('sales.searchSlip');
Route::get('/sales/details/{id}', [SalesController::class, 'detail'])->name('sales.detail');



