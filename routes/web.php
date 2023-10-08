<?php
 
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
 
=======
use App\Http\Controllers\FormController;

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

>>>>>>> Stashed changes
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
 
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
<<<<<<< Updated upstream
  
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
 
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('products');
        Route::get('create', 'create')->name('products.create');
        Route::post('store', 'store')->name('products.store');
        Route::get('show/{id}', 'show')->name('products.show');
        Route::get('edit/{id}', 'edit')->name('products.edit');
        Route::put('edit/{id}', 'update')->name('products.update');
        Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
    });
 
    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
});
=======

Route::post('/LoginCall', [FormController::class, 'LoginCall'])->name('LoginCall');

Route::post('/RegisterCall', [FormController::class, 'RegisterCall'])->name('RegisterCall');
>>>>>>> Stashed changes
