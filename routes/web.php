<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\Vendor\TenderClarificationController;
use App\Http\Controllers\SupplyChain\ChatNegosiasiController;
use App\Http\Controllers\PlannerMaterialRequestController;
use App\Http\Controllers\SupplyChain\VendorController;
use App\Http\Controllers\SupplyChain\MaterialRequestController as SupplyChainMaterialRequestController;
use App\Http\Controllers\SupplyChain\TenderController;
use App\Http\Controllers\Vendor\TenderController as VendorTenderController;
use App\Http\Controllers\SupplyChain\PurchaseOrderController as SupplyChainPurchaseOrderController;
use App\Http\Controllers\Vendor\PurchaseOrderController as VendorPurchaseOrderController;
use App\Http\Controllers\Vendor\TenderClarificationController as VendorTenderClarificationController;
use App\Http\Controllers\Engineer\TenderClarificationController as EngineerTenderClarificationController;
use App\Http\Controllers\FcmTokenController;
use App\Services\FirebaseService;
use App\Http\Controllers\Gudang\DashboardController as GudangDashboardController;
use App\Http\Controllers\Gudang\GoodsReceiptController;
use App\Http\Controllers\SupplyChain\GoodsReceiptReportController;

Route::get('/test-firebase', function (
    App\Services\FirebaseService $firebase
) {

    $firebase->sendNotification(
        'TOKEN_FIREBASE_KAMU',
        'Test Notification',
        'Firebase Laravel berhasil'
    );


    return "terkirim";
});
Route::get('/', function () {
    return view('welcome');
});

// FCM Token storage (must be inside auth middleware)
Route::post('/fcm-token', [FcmTokenController::class, 'update'])
    ->middleware('auth')
    ->name('fcm.token.update');

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
    Route::prefix('engineer')->name('engineer.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Engineer\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/clarifications', [EngineerTenderClarificationController::class, 'index'])
            ->name('clarifications.index');

        Route::get('/clarifications/{tender}/{vendor}', [EngineerTenderClarificationController::class, 'show'])
            ->name('clarifications.show');

        Route::post('/clarifications/{tender}/{vendor}', [EngineerTenderClarificationController::class, 'reply'])
            ->name('clarifications.reply');

        // AJAX polling for real-time chat
        Route::get('/clarifications/{tender}/{vendor}/messages', [EngineerTenderClarificationController::class, 'messagesAjax'])
            ->name('clarifications.messages.ajax');

        // Monitoring Kebutuhan Material
        Route::get('/monitoring', [\App\Http\Controllers\Engineer\MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('/monitoring/{id}', [\App\Http\Controllers\Engineer\MonitoringController::class, 'show'])->name('monitoring.show');
    });

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

    Route::get('/supply-chain/dashboard', [\App\Http\Controllers\SupplyChain\DashboardController::class, 'index'])->name('supply-chain.dashboard');

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

        // CHAT NEGOSIASI
        // LIST CHAT PER TENDER
        Route::get(
            '/tenders/{tender}/negotiation',
            [ChatNegosiasiController::class, 'index']
        )->name('chat.negosiasi.index');

        // CHAT DETAIL PER VENDOR
        Route::get(
            '/tenders/{tender}/negotiation/{vendor}',
            [ChatNegosiasiController::class, 'show']
        )->name('chat.negosiasi.show');

        // SEND MESSAGE
        Route::post(
            '/tenders/{tender}/negotiation/{vendor}',
            [ChatNegosiasiController::class, 'send']
        )->name('chat.negosiasi.send');

        // AJAX polling for real-time chat
        Route::get(
            '/tenders/{tender}/negotiation/{vendor}/messages',
            [ChatNegosiasiController::class, 'messagesAjax']
        )->name('chat.negosiasi.messages.ajax');

        // Laporan Penerimaan Barang (dari Gudang)
        Route::get('/goods-receipts', [\App\Http\Controllers\SupplyChain\GoodsReceiptController::class, 'index'])->name('goods-receipts.index');
        Route::get('/goods-receipts/{goodsReceipt}', [\App\Http\Controllers\SupplyChain\GoodsReceiptController::class, 'show'])->name('goods-receipts.show');

        // Monitoring Pengadaan Material
        Route::resource('monitoring', \App\Http\Controllers\SupplyChain\MonitoringController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
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

        Route::get('/purchase-orders', [VendorPurchaseOrderController::class, 'index'])->name('purchase-orders.index');
        Route::get('/purchase-orders/{purchaseOrder}', [VendorPurchaseOrderController::class, 'show'])->name('purchase-orders.show');
        Route::post('/purchase-orders/{purchaseOrder}/ship', [VendorPurchaseOrderController::class, 'ship'])->name('purchase-orders.ship');

        // OPEN CHAT
        Route::get(
            '/tenders/{invitation}/chat',
            [VendorTenderClarificationController::class, 'chat']
        )->name('tenders.chat');

        // SEND MESSAGE
        Route::post(
            '/tenders/{invitation}/chat',
            [VendorTenderClarificationController::class, 'store']
        )->name('tenders.chat.send');

        // NEGOTIATION (FIXED)
        Route::get(
            '/tenders/{invitation}/chat-negotiation',
            [VendorTenderClarificationController::class, 'negotiation']
        )->name('tenders.chat.negotiation');

        Route::post(
            '/tenders/{invitation}/chat-negotiation',
            [VendorTenderClarificationController::class, 'sendNegotiation']
        )->name('tenders.chat.negotiation.send');

        // AJAX polling for real-time chat
        Route::get(
            '/tenders/{invitation}/chat/messages',
            [VendorTenderClarificationController::class, 'clarificationMessagesAjax']
        )->name('tenders.chat.messages.ajax');

        Route::get(
            '/tenders/{invitation}/chat-negotiation/messages',
            [VendorTenderClarificationController::class, 'negotiationMessagesAjax']
        )->name('tenders.chat.negotiation.messages.ajax');
    });
    // gudang
    Route::get('/gudang/dashboard', [GudangDashboardController::class, 'index'])->name('gudang.dashboard');

    Route::prefix('gudang')->name('gudang.')->group(function () {
        Route::get('/goods-receipts', [GoodsReceiptController::class, 'index'])->name('goods-receipts.index');
        Route::get('/goods-receipts/report/{receipt}', [GoodsReceiptController::class, 'showReport'])->name('goods-receipts.report');
        Route::get('/goods-receipts/{purchaseOrder}', [GoodsReceiptController::class, 'show'])->name('goods-receipts.show');
        Route::post('/goods-receipts/{purchaseOrder}', [GoodsReceiptController::class, 'store'])->name('goods-receipts.store');
    });

    // Supply Chain — Laporan Penerimaan Gudang
    Route::prefix('supply-chain')->name('supply-chain.')->group(function () {
        Route::get('/goods-receipt-reports', [GoodsReceiptReportController::class, 'index'])->name('goods-receipt-reports.index');
        Route::get('/goods-receipt-reports/{goodsReceiptReport}', [GoodsReceiptReportController::class, 'show'])->name('goods-receipt-reports.show');
        Route::post('/goods-receipt-reports/{goodsReceiptReport}/confirm', [GoodsReceiptReportController::class, 'confirm'])->name('goods-receipt-reports.confirm');
        Route::post('/goods-receipt-reports/{goodsReceiptReport}/return', [GoodsReceiptReportController::class, 'processReturn'])->name('goods-receipt-reports.return');
    });
});



require __DIR__ . '/auth.php';
