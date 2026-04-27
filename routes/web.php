<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('homenew');
});

//route logout
Route::get('/logout', [App\Http\Controllers\LoginApi::class, 'logout'])->name('logout');

//Route ke fungsi search
Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');

//Route ke api login
Route::post('/api/login', [App\Http\Controllers\LoginApi::class, 'loginApi']);
Route::get('/login', [App\Http\Controllers\LoginApi::class, 'login'])->name('login');

// Group untuk role admin & super admin yang membutuhkan token_api
Route::middleware(['token_api'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/satker', [App\Http\Controllers\AdminController::class, 'satker'])->name('admin.satker');
});


