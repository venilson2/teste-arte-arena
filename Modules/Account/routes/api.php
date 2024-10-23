<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Account\App\Http\Controllers\AccountApiController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['api'])->name('api.')->group(function () {
    Route::get('accounts', [AccountApiController::class, 'index'])->name('accounts.index');
    Route::get('accounts/{id}', [AccountApiController::class, 'show'])->name('accounts.show');
    Route::post('accounts', [AccountApiController::class, 'store'])->name('accounts.store');
    Route::put('accounts/{id}', [AccountApiController::class, 'update'])->name('accounts.update');
    Route::delete('accounts/{id}', [AccountApiController::class, 'destroy'])->name('accounts.destroy');
});
