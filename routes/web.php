<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\PlannerMaterialRequestController;
use App\Http\Controllers\SupplyChain\VendorController;
use App\Http\Controllers\SupplyChain\MaterialRequestController as SupplyChainMaterialRequestController;
use App\Http\Controllers\SupplyChain\TenderController;
use App\Http\Controllers\Vendor\TenderController as VendorTenderController;
use App\Http\Controllers\SupplyChain\PurchaseOrderController as SupplyChainPurchaseOrderController;
use App\Http\Controllers\Vendor\PurchaseOrderController as VendorPurchaseOrderController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($role === 'engineer') {
        return redirect()->route('engineer.dashboard');
    }

    if ($role === 'planner') {
        return redirect()->route('planner.dashboard');
    }

    if ($role === 'supply_chain') {
        return redirect()->route('supply-chain.dashboard');
    }

    if ($role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    }

    if ($role === 'gudang') {
        return redirect()->route('gudang.dashboard');
    }

    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->name('admin.dashboard');


    // engineer
    Route::get('/engineer/dashboard', function () {
        return view('dashboards.engineer');
    })->name('engineer.dashboard');

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


    // palanner
    Route::get('/planner/dashboard', function () {
        return view('dashboards.planner');
    })->name('planner.dashboard');

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


    // supplychain
    // Route::get('/supply-chain/dashboard', function () {
    //     return view('dashboards.supply');
    // })->name('supply.dashboard');

    Route::get('/supply-chain/dashboard', function () {
        return view('dashboards.supply');
    })->name('supply-chain.dashboard');

    Route::prefix('supply-chain')->name('supply-chain.')->group(function () {
        Route::resource('vendors', VendorController::class);

        Route::get('/material-requests', [SupplyChainMaterialRequestController::class, 'index'])
            ->name('material-requests.index');

        Route::get('/material-requests/{id}', [SupplyChainMaterialRequestController::class, 'show'])
            ->name('material-requests.show');

        Route::get('/tenders', [TenderController::class, 'index'])
            ->name('tenders.index');

        Route::get('/material-requests/{materialRequest}/tenders/create', [TenderController::class, 'create'])
            ->name('tenders.create');

        Route::post('/tenders', [TenderController::class, 'store'])
            ->name('tenders.store');

        Route::get('/tenders/{tender}', [TenderController::class, 'show'])
            ->name('tenders.show');

        Route::post('/tenders/{tender}/quotations/{quotation}/choose', [TenderController::class, 'chooseVendor'])
            ->name('tenders.quotations.choose');
        Route::get('/purchase-orders', [SupplyChainPurchaseOrderController::class, 'index'])
            ->name('purchase-orders.index');

        Route::get('/tenders/{tender}/purchase-orders/create', [SupplyChainPurchaseOrderController::class, 'create'])
            ->name('purchase-orders.create');

        Route::post('/purchase-orders', [SupplyChainPurchaseOrderController::class, 'store'])
            ->name('purchase-orders.store');

        Route::get('/purchase-orders/{purchaseOrder}', [SupplyChainPurchaseOrderController::class, 'show'])
            ->name('purchase-orders.show');
    });


    // Vendor
    Route::get('/vendor/dashboard', function () {
        return view('dashboards.vendor');
    })->name('vendor.dashboard');

    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/tenders', [VendorTenderController::class, 'index'])
            ->name('tenders.index');

        Route::get('/tenders/{id}', [VendorTenderController::class, 'show'])
            ->name('tenders.show');

        Route::post('/tenders/{id}/quotation', [VendorTenderController::class, 'storeQuotation'])
            ->name('tenders.quotation.store');

        Route::get('/purchase-orders', [VendorPurchaseOrderController::class, 'index'])
            ->name('purchase-orders.index');

        Route::get('/purchase-orders/{purchaseOrder}', [VendorPurchaseOrderController::class, 'show'])
            ->name('purchase-orders.show');
    });

    // gudang
    Route::get('/gudang/dashboard', function () {
        return view('dashboards.gudang');
    })->name('gudang.dashboard');
});

require __DIR__ . '/auth.php';
