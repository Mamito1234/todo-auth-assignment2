<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;

Route::middleware(['auth'])->group(function () {
    Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store']);
});
Route::post('/login', [CustomLoginController::class, 'store']);



Route::get('/two-factor-challenge', function () {
    return view('auth.two-factor-challenge');
})->middleware(['guest'])->name('two-factor.login');

Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
    ->middleware(['guest']);

Route::get('/', function () {
    return view('welcome');
});

// Default Laravel auth routes
// Auth::routes();

// Optional: HomeController (not used if you're redirecting to /todo)
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('home');

// To-Do routes — protected by auth + verified (MFA)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
});

// Profile routes — still using auth only (optional to also add 'verified')
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes requiring confirmed 2FA (optional, advanced use)
Route::middleware(['auth', 'two-factor'])->group(function () {
    Route::get('/sensitive', fn () => 'Only accessible after 2FA confirmed.');
});


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Auth::routes();
// Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
// Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
// Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
// Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
// Route::put('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
// Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');


// Route::middleware(['auth'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
