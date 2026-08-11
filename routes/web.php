<?php

use App\Http\Controllers\Auth\AdminInviteRegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/admin/login', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login']);

// Admin Invite Registration
Route::get('/admin/register/invite', [AdminInviteRegisterController::class, 'showForm'])->name('admin.invite.register');
Route::post('/admin/register/invite', [AdminInviteRegisterController::class, 'register'])->name('admin.invite.register.submit');
