<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberExportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::view('/styleguide', 'styleguide')->name('styleguide');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['unverified'])->group(function () {
        Route::get('/change-password', [PasswordChangeController::class, 'index'])->name('verification.notice');
        Route::put('/change-password', [PasswordChangeController::class, 'update'])->name('password.change');
    });

    Route::middleware(['verified'])->group(function () {
        Route::get('members/export', MemberExportController::class)->name('members.export');
        Route::resource('members', MemberController::class);

        Route::get('profile', [UserController::class, 'show'])->name('users.show');
        Route::get('profile/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('profile', [UserController::class, 'update'])->name('users.update');
    });
});
