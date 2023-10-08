<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;


Route::get('/', function () {
    return view('landingPage');
});

Route::get('/landingPage', function () {
    return view('landingPage');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/invoice', function () {
    return view('invoice');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/pemesanan', function () {
    return view('pemesanan');
});

Route::get('/landingPageLogin', function () {
    return view('landingPageLogin');
});

Route::post('/LoginCall', [FormController::class, 'LoginCall'])->name('LoginCall');
Route::post('/RegisterCall', [FormController::class, 'RegisterCall'])->name('RegisterCall');

