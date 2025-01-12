<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/sercing-data-pesanan', [SearchController::class, 'index'])->name('sercing-data-pesanan.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
});



require __DIR__ . '/auth.php';
require __DIR__ . '/master.php';
require __DIR__ . '/gudang.php';
require __DIR__ . '/kasir.php';
require __DIR__ . '/admin.php';
