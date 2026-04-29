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
    Route::get('/admin/satker', [App\Http\Controllers\SatkerController::class, 'index'])->name('admin.satker');
    Route::post('/admin/satker', [App\Http\Controllers\SatkerController::class, 'store'])->name('admin.satker.create');
    Route::put('/admin/satker/{id}', [App\Http\Controllers\SatkerController::class, 'update'])->name('admin.satker.update');
    Route::delete('/admin/satker/{id}', [App\Http\Controllers\SatkerController::class, 'destroy'])->name('admin.satker.delete');
});


//route group dengan token_user
Route::middleware(['token_user'])->group(function () {
    Route::get('/pengadilan', [App\Http\Controllers\PengadilanController::class, 'index'])->name('pengadilan');
    Route::post('/pengadilan', [App\Http\Controllers\PengadilanController::class, 'store'])->name('pengadilan.store');
    Route::get('/pengadilan/{id}', [App\Http\Controllers\PengadilanController::class, 'show'])->name('pengadilan.show');
    Route::get('/pengadilan/{id}/edit', [App\Http\Controllers\PengadilanController::class, 'edit'])->name('pengadilan.edit');
    Route::put('/pengadilan/{id}', [App\Http\Controllers\PengadilanController::class, 'update'])->name('pengadilan.update');
});

