<?php

use App\Http\Actions\Currency\GetCurrencies;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PromoController;
use \App\Http\Controllers\SystemController;
use \App\Http\Controllers\p2pController;
use \App\Http\Controllers\TransactionController;
use \App\Http\Controllers\OrderController;
use \App\Http\Controllers\SwapController;


Route::view("/", "pages.home");






Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'p2p'], function () {
        Route::get("/{currency_from}/{currency_to}", [p2pController::class, 'show_sort'])->name('p2p.sort.show:id:id');
        Route::get("/", [p2pController::class, 'index'])->name('p2p');
    });

    Route::get('/balance/get', [UserController::class, 'balance'])->name('balance.get');
    Route::get("/logout", [UserController::class, 'logout'])->name('logout');
    Route::get("/profile", [UserController::class, 'profile'])->name('profile');
    Route::group(['prefix' => 'transaction'],     function () {
        Route::post('/create', [TransactionController::class, 'create'])->name('transaction.create');
        Route::post('/change', [TransactionController::class, 'change'])->name('transaction.change');
        Route::get('/get/open', [TransactionController::class, 'open'])->name('transaction.open');

    });

    Route::post('/deposit/create', [OrderController::class, 'deposit']);
    Route::group(['prefix' => 'order'], function () {
        Route::get('/get/{id}', [OrderController::class, 'get'])->name('order.get:id');
    });

    Route::group(['prefix' => 'swap'], function () {
        Route::get('/', [SwapController::class, 'index'])->name('swap');
        Route::post('/', [SwapController::class, 'swap'])->name('swap.post');
        Route::post('/data', [SwapController::class, 'data'])->name('swap.data');

    });
    Route::get('/create/transfer', [SystemController::class, 'createTransfer'])->name('create.transfer');
    Route::get('/currency/convert/{from}/{to}/{amount}', [SystemController::class, 'convert'])->name('currency.convert');
    Route::get('/currency/to_main_cur/{from}/{amount}', [SystemController::class, 'convertToMainCur'])->name('currency.convert.to_main_cur');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get("/login", [SystemController::class, 'login'])->name('login');
    Route::get("/register", [SystemController::class, 'register'])->name('register');

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [UserController::class, 'login'])->name('auth.login');
        Route::post('/promo/exist', [PromoController::class, 'exist'])->name('promo.exist');
        Route::post('/exist', [UserController::class, 'exist'])->name('auth.exist');
        Route::post('/register', [UserController::class, 'register'])->name('auth.register');
    });
});


Route::get('/language/{lang}', [SystemController::class, 'setLanguage'])->name('language:lang');

Route::get('/test', function () {
    $orders = \App\Models\Order::factory(100)->create();
});

