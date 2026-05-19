<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\PlannerMaterialRequestController;

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

    Route::get('/material-requests', [MaterialRequestController::class, 'index'])
        ->name('material-requests.index');

    Route::get('/material-requests/create', [MaterialRequestController::class, 'create'])
        ->name('material-requests.create');

    Route::post('/material-requests', [MaterialRequestController::class, 'store'])
        ->name('material-requests.store');

    Route::get('/material-requests/{id}', [MaterialRequestController::class, 'show'])
        ->name('material-requests.show');

    Route::get('/material-requests/{id}/edit', [MaterialRequestController::class, 'edit'])
        ->name('material-requests.edit');

    Route::put('/material-requests/{id}', [MaterialRequestController::class, 'update'])
        ->name('material-requests.update');

    Route::delete('/material-requests/{id}', [MaterialRequestController::class, 'destroy'])
        ->name('material-requests.destroy');

    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->name('admin.dashboard');

    Route::get('/engineer/dashboard', function () {
        return view('dashboards.engineer');
    })->name('engineer.dashboard');

    Route::get('/planner/material-requests', [PlannerMaterialRequestController::class, 'index'])
        ->name('planner.material-requests.index');

    Route::get('/planner/material-requests/{id}', [PlannerMaterialRequestController::class, 'show'])
        ->name('planner.material-requests.show');

    Route::post('/planner/material-requests/{id}/documents', [PlannerMaterialRequestController::class, 'uploadDocuments'])
        ->name('planner.material-requests.documents');

    Route::post('/planner/material-requests/{id}/approve', [PlannerMaterialRequestController::class, 'approve'])
        ->name('planner.material-requests.approve');

    Route::post('/planner/material-requests/{id}/reject', [PlannerMaterialRequestController::class, 'reject'])
        ->name('planner.material-requests.reject');

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
