<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Auth::routes([
    'login' => true,
    'register' => config('features.update-user-registration'),
    'reset' => config('features.update-reset-password'),
    'verify' => config('features.update-email-verification'),
]);
Route::get('/two-factor-challenge', [\App\Http\Controllers\Auth\LoginController::class, 'twoFactorChallenge'])->name('two-factor-challenge');
Route::post('/login/2fa', [\App\Http\Controllers\Auth\LoginController::class, 'attempt2fa'])->name('login.2fa');
Route::get('/two-factor-recovery', [\App\Http\Controllers\Auth\LoginController::class, 'twoFactorRecovery'])->name('two-factor-recovery');
Route::post('/login/2fa/recovery', [\App\Http\Controllers\Auth\LoginController::class, 'attempt2faRecovery'])->name('login.2fa.recovery');

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'disable-move-back'])->middleware(config('features.update-email-verification') ? ['verified'] : [])->group(function () {
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', function () {
        return view('profile');
    })->middleware(['password.confirm'])->name('profile');
});
