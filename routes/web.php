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

