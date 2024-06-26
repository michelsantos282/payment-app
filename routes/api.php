<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Transaction\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('user', [AuthController::class, 'test'])->name('auth.test');

Route::group(['prefix' => 'auth'], function () {
   Route::post('login', [AuthController::class, 'index'])->name('auth.login');
   Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
   Route::post('register', [RegisterController::class, 'index'])->name('auth.register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('transaction', [TransactionController::class, 'index']);
});

Route::get('test', function (){
    $response = Http::get('https://util.devi.tools/api/v2/authorize');
    if ($response->successful()) {
        return true;
    }
    return false;
});
