<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallUserController;
use App\Http\Controllers\DataLinkerController;

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

Route::get('/panduan', function () {
    return view('panduan');
})->name('panduan');

Route::get('/adminDashboard', function () {
    return view('adminDashboard');
})->name('admindashboard');

// User Data
Route::post('/LoginCall', [CallUserController::class, 'LoginCall'])->name('LoginCall');
Route::post('/RegisterCall', [CallUserController::class, 'RegisterCall'])->name('RegisterCall');
Route::patch('/UpdateProfileCall', [CallUserController::class, 'UpdateProfileCall'])->name('UpdateProfileCall');
Route::patch('/UpdatePasswordCall', [CallUserController::class, 'UpdatePasswordCall'])->name('UpdatePasswordCall');
Route::delete('/LogoutCall', [CallUserController::class, 'LogoutCall'])->name('LogoutCall');

// Order Data
Route::post('/SimpanPesanan', [DataLinkerController::class, 'SendToDetailUkuran'])->name('SimpanPesanan');
Route::post('/SimpanUkuran', [DataLinkerController::class, 'SendToUploadAndView'])->name('SimpanUkuran');
Route::get('/UkuranHalamanSelanjutnya', [DataLinkerController::class, 'LoadNextPacketData'])->name('UkuranHalamanSelanjutnya');
Route::get('/UkuranHalamanSebelumnya', [DataLinkerController::class, 'LoadPrevPacketData'])->name('UkuranHalamanSebelumnya');
