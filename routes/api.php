<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PacketController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthenticationController;

Route::post('/UserLogin', [AuthenticationController::class, 'Login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserLogout', [AuthenticationController::class, 'Logout']);
    Route::get('/UserCheck', [AuthenticationController::class, "Check"]);
});

Route::post('/UserRegister', [RegisterController::class, 'RegisterCostumer']);
Route::post('/CheckEmail', [RegisterController::class, 'EmailCheck']);
Route::post('/CheckUsername', [RegisterController::class, 'UsernameCheck']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserOrders', [OrderController::class, 'GetUserOrders']);
    Route::post('/StoreOrder', [OrderController::class, 'StoreOrder']);
    Route::put('/CancelOrder/{order_id}', [OrderController::class, 'CancelOrder']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/AddPacket', [PacketController::class, 'AddPacket']);
    Route::get('/PacketList', [PacketController::class, 'GetPacketList']);
    Route::get('/AgentPacketList', [PacketController::class, 'AgentPacketList']);
    Route::put('/HidePacket/{packet_id}', [PacketController::class, 'HidePacket']);
    Route::put('/UnHidePacket/{packet_id}', [PacketController::class, 'UnHidePacket']);
});
