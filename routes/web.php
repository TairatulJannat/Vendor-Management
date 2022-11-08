<?php

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

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

Route::get('/verdor-info', [VendorController::class, 'create'])->name('vendor.create');
Route::post('/submit-form', [VendorController::class, 'store'])->name('vendor.store');
Route::get('/edit-form/{id}', [VendorController::class, 'edit'])->name('vendor.edit');
Route::post('/update-form/{id}', [VendorController::class, 'update']);
Route::get('/delete-form/{id}', [VendorController::class, 'destroy'])->name('vendor.delete');


Route::get('/purchase-order', [PurchaseController::class, 'create'])->name('purchase.create');
Route::post('/purchase-form', [PurchaseController::class, 'store'])->name('purchase.store');