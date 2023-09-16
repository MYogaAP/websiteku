<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationController;

Route::post('/UserLogin', [AuthenticationController::class, 'Login']);
Route::get('/UserLogout', [AuthenticationController::class, 'Logout'])->middleware(['auth:sanctum']);
Route::get('/UserCheck', [AuthenticationController::class, "Check"])->middleware(['auth:sanctum']);