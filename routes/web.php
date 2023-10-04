<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
