<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthenticationController;

Route::post('/UserLogin', [AuthenticationController::class, 'Login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserLogout', [AuthenticationController::class, 'Logout']);
    Route::get('/UserCheck', [AuthenticationController::class, "Check"]);
});

Route::post('/UserRegister', [RegisterController::class, 'RegisterCostumer']);
Route::post('/CheckEmail', [RegisterController::class, 'EmailCheck']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserOrders/{id}', [OrderController::class, 'GetUserOrders']);
    Route::post('/StoreOrder', [OrderController::class, 'StoreOrder']);
    Route::put('/CancelOrder/{order_id}', [OrderController::class, 'CancelOrder']);
});
