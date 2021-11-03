<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::prefix('user')->group(function(){
    Route::get('/', [UserController::class,'index']);
    Route::get('/{id}', [UserController::class,'show']);
    Route::post('/', [UserController::class,'store']);
    Route::put('/{id}', [UserController::class,'update']);
    Route::delete('/{id}', [UserController::class,'destroy']);

    /**
     * Wallet routes endpoints
     */
    Route::prefix('/wallet')->group(function () {
        Route::get('/balance', [UserController::class,'getBalance']);
        Route::post('/deposit', [UserController::class,'deposit']);
        Route::post('/transfer', [UserController::class,'transfer']);
    });
});
