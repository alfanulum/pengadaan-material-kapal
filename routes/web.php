<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->name('admin.dashboard');

    Route::get('/engineer/dashboard', function () {
        return view('dashboards.engineer');
    })->name('engineer.dashboard');

    Route::get('/planner/dashboard', function () {
        return view('dashboards.planner');
    })->name('planner.dashboard');

    Route::get('/supply-chain/dashboard', function () {
        return view('dashboards.supply');
    })->name('supply.dashboard');

    Route::get('/gudang/dashboard', function () {
        return view('dashboards.gudang');
    })->name('gudang.dashboard');

    Route::get('/vendor/dashboard', function () {
        return view('dashboards.vendor');
    })->name('vendor.dashboard');
});

require __DIR__ . '/auth.php';
