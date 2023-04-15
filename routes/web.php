<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\SendVoucherController;
use App\Http\Controllers\Admin\Voucher\VoucherController;
/*
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


Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    #Homepage
    Route::get('/', [MainController::class, 'index'])->name('index');
    #voucher
    Route::resource('voucher', VoucherController::class);
    #customer
    Route::resource('customer', CustomerController::class);

    #Change Password
    Route::get('/change-password', [LoginController::class, 'changePassword'])->name('change_password');
    Route::put('/change-password', [LoginController::class, 'updatePassword']);

    #Give voucher by choose user
    Route::post('/availabe-recipient', [SendVoucherController::class, 'getCustomers'])->name('get_availabe_recipient');
    Route::post('/give-voucher-by-choose-user', [SendVoucherController::class, 'giveVoucherByUser'])->name('give_voucher_by_user');

    #Give voucher by choose voucher
    Route::post('/customer/{customer}', [SendVoucherController::class, 'giveVoucherByVoucher'])->name('give_voucher_by_voucher');
});
