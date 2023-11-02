<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\CallUserController;
use App\Http\Controllers\CallAgentController;
use App\Http\Controllers\CallOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataLinkerController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

Route::get('/paketData', function () {
    return view('paketData');
})->name('paketData');

Route::get('/orderData', function () {
    return view('orderData');
})->name('orderData');

Route::get('/agentData', function () {
    return view('agentData');
})->name('agentData');

Route::get('/riwayatDetail', function () {
    return view('riwayatDetail');
})->name('riwayatDetail');

Route::get('/landingPagePro', function () {
    return view('landingPagePro');
})->name('landingPagePro');

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
Route::post('/NewOrderCall', [CallOrderController::class, 'NewOrderAndInvoiceCall'])->name('NewOrderCall');
Route::delete('/DeleteOrderCall/{order}', [CallOrderController::class, 'DeleteOrderCall'])->name('DeleteOrderCall');

// Riwayat
Route::get('/SendToRiwayat', [DataLinkerController::class, 'SendToRiwayat'])->name('SendToRiwayatUser');
Route::get('/OrderHalamanSelanjutnya', [DataLinkerController::class, 'LoadNextOrderData'])->name('UserOrderHalamanSelanjutnya');
Route::get('/OrderHalamanSebelumnya', [DataLinkerController::class, 'LoadPrevOrderData'])->name('UserOrderHalamanSebelumnya');
Route::get('/OrderHalaman/{page}', [DataLinkerController::class, 'LoadNumberOrderData'])->name('UserOrderHalamanNomor');

// Dashboard Admin Order

// Dashboard Admin Packet
Route::post('/TambahPaket', [DashboardController::class, 'AddNewPacket'])->name('TambahPaket');
Route::patch('/SembunyikanPaket/{packet}', [DashboardController::class, 'HideThePacket'])->name('SembunyikanPaket');
Route::patch('/TampilkanPaket/{packet}', [DashboardController::class, 'UnhideThePacket'])->name('TampilkanPaket');
Route::delete('/HapusPaket/{packet}', [DashboardController::class, 'DeleteThePacket'])->name('HapusPaket');

// Dashboard Admin Agent Data
Route::post('/TambahAgent', [CallAgentController::class, 'AddTheAgent'])->name('TambahAgent');
Route::patch('/UpdateAgent', [CallAgentController::class, 'UpdateTheAgent'])->name('UpdateAgent');
Route::delete('/HapusAgent/{agent}', [CallAgentController::class, 'DeleteTheAgent'])->name('HapusAgent');

// Forgot Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(
        ['email' => 'required|email']
    );
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('loginPage')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

