<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('homenew');
});

Route::get('/admin', function () {
    return view('admin.layouts.app');
})->name('admin');

//Route ke fungsi search
Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');

//Route ke api login
Route::post('/api/login', [App\Http\Controllers\LoginApi::class, 'loginApi']);
Route::get('/login', [App\Http\Controllers\LoginApi::class, 'login'])->name('login');


