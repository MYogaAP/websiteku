<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginCallController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/test2', function () {
    return view('test2');
});

Route::get('/test3', function () {
    return view('test3');
});

Route::get('/test4', function () {
    return view('test4');
});

Route::get('/login-test', function () {
    return view('login-test');
})->name('LandingPage');

Route::get('/register-test', function () {
    return view('register-test');
});

Route::post('/logincall', [LoginCallController::class, 'LoginCall'])->name('logincall');
Route::post('/registercall', [LoginCallController::class, 'RegisterCall'])->name('registercall');

