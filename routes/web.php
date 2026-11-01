<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotteryGameController;
use App\Http\Controllers\LotteryDrawDayController;
use App\Http\Controllers\LotteryAccumulatedController;
use App\Http\Controllers\LotteryPoolController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('lottery-games', LotteryGameController::class)->except(['create', 'show', 'edit']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('lottery-draw-days', LotteryDrawDayController::class)->except(['create', 'show', 'edit']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('lottery-accumulateds', LotteryAccumulatedController::class)->except(['create', 'show', 'edit']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('lottery-pools', LotteryPoolController::class)->except(['create', 'show', 'edit']);
});

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
