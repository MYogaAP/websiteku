<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;


Route::get('/', function () {
    return view('landingPage');
})->name('landingPage');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('loginPage');

Route::get('/register', function () {
    return view('register');
})->name('registerPage');

Route::get('/invoice', function () {
    return view('invoice');
})->name('invoice');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/detailukuran', function () {
    return view('DetailUkuran');
})->name('detailukuran');

Route::get('/pemesanan', function () {
    return view('pemesanan');
})->name('pemesanan');

Route::get('/landingPageLogin', function () {
    return view('landingPageLogin');
})->name('landingPageLogin');

Route::get('/uploadandview', function () {
    return view('uploadandview');
})->name('uploadandview');

Route::post('/LoginCall', [FormController::class, 'LoginCall'])->name('LoginCall');
Route::post('/RegisterCall', [FormController::class, 'RegisterCall'])->name('RegisterCall');
Route::patch('/UpdateProfileCall', [FormController::class, 'UpdateProfileCall'])->name('UpdateProfileCall');
Route::patch('/UpdatePasswordCall', [FormController::class, 'UpdatePasswordCall'])->name('UpdatePasswordCall');
Route::delete('/LogoutCall', [FormController::class, 'LogoutCall'])->name('LogoutCall');


