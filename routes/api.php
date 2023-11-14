<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PacketController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\AgentUserController;
use App\Http\Controllers\API\AuthenticationController;

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
    Route::patch('/UpdateUserProfile', [AgentUserController::class, "UpdateProfile"]);
    Route::get('/AgentList', [AgentUserController::class, "AgentList"])->middleware('an.admin');
    Route::patch('/AdminUpdateAgentProfile/{user_id}', [AgentUserController::class, "AdminUpdateAgentProfile"])->middleware('an.admin');
    Route::delete('/DeleteAgent/{user_id}', [AgentUserController::class, "DeleteAgent"])->middleware('an.admin');
});

// Order API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/UserOrdersList', [OrderController::class, 'GetUserOrdersList']);
    Route::post('/CheckImage', [OrderController::class, 'CheckImage']);
    Route::middleware(['an.agent'])->group(function () {
        Route::get('/AgentAllDetailedOrders', [OrderController::class, 'AllDetailedOrders']);
        Route::get('/AgentResponsibility', [OrderController::class, 'AgentResponsibilityOrders']);
        Route::get('/NeedConfirmation', [OrderController::class, 'NeedConfirmation']);
        Route::patch('/UpdateOrder/{order_id}/{update_type}/{status}', [OrderController::class, 'UpdateOrder']);
        Route::post('/UpdatePayedOrder/{order_id}', [OrderController::class, 'OrderPayed']);
        Route::post('/ConfirmOrder/{order_id}/{update_type}', [OrderController::class, 'ConfirmOrder']);
        Route::get('/AgentOrderDetail/{order_id}', [OrderController::class, 'GetOrderDetailWithUser']);
    });
    Route::get('/OrderDetail/{order_id}', [OrderController::class, 'GetOrderDetail']);
    Route::post('/StoreOrder', [OrderController::class, 'StoreOrder']);
    Route::post('/CancelOrder/{order_id}', [OrderController::class, 'CancelOrder']);
});

// Packet API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/PacketList', [PacketController::class, 'GetPacketList']);
    Route::get('/GetPacketColor/{packet_id}', [PacketController::class, 'GetPacketColor']);
    Route::get('/GetPacket/{packet_id}', [PacketController::class, 'GetPacket']);
    Route::middleware(['an.agent'])->group(function () {
        Route::post('/AddPacket', [PacketController::class, 'AddPacket']);
        Route::get('/AgentPacketList', [PacketController::class, 'AgentPacketList']);
        Route::patch('/HidePacket/{packet_id}', [PacketController::class, 'HidePacket']);
        Route::patch('/UnHidePacket/{packet_id}', [PacketController::class, 'UnHidePacket']);
        Route::delete('/DeletePacket/{packet_id}', [PacketController::class, 'DeletePacket']);
    });
});

// Email Verif
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/VerifEmailUserAPI/{id}/{hash}', [RegisterController::class, 'VerifEmailUser']);
    Route::get('/SendVerifEmail', [RegisterController::class, 'SendAnVerifEmail']);
});
