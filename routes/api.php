<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PacketController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AgentUserController;
use App\Http\Controllers\AuthenticationController;

//Login API
Route::post('/UserLogin', [AuthenticationController::class, 'Login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserLogout', [AuthenticationController::class, 'Logout']);
});

//Register API
Route::post('/UserRegister', [RegisterController::class, 'RegisterCostumer']);
Route::post('/AgentRegister', [RegisterController::class, 'RegisterAgent'])->middleware(['auth:sanctum', 'an.admin']);
Route::post('/CheckEmail', [RegisterController::class, 'EmailCheck']);
Route::post('/CheckUsername', [RegisterController::class, 'UsernameCheck']);

//User Data API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserCheck', [AgentUserController::class, "CheckCurrent"]);
    Route::patch('/UpdateUserPassword', [AgentUserController::class, "UpdatePassword"]);
    Route::delete('/DeleteAgent/{user_id}', [AgentUserController::class, "DeleteAgent"])->middleware('an.admin');
});

// Order API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserOrdersList', [OrderController::class, 'GetUserOrdersList']);
    Route::get('/AgentAllOrders', [OrderController::class, 'AllOrders'])->middleware('an.agent');
    Route::get('/OrderDetail/{order_id}', [OrderController::class, 'GetOrderDetail']);
    Route::post('/StoreOrder', [OrderController::class, 'StoreOrder']);
    Route::delete('/CancelOrder/{order_id}', [OrderController::class, 'CancelOrder']);
});

// Packet API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/PacketList', [PacketController::class, 'GetPacketList']);
    Route::middleware(['an.agent'])->group(function () {
        Route::post('/AddPacket', [PacketController::class, 'AddPacket']);
        Route::get('/AgentPacketList', [PacketController::class, 'AgentPacketList']);
        Route::patch('/HidePacket/{packet_id}', [PacketController::class, 'HidePacket']);
        Route::patch('/UnHidePacket/{packet_id}', [PacketController::class, 'UnHidePacket']);
        Route::delete('/DeletePacket/{packet_id}', [PacketController::class, 'DeletePacket']);
    });
});
