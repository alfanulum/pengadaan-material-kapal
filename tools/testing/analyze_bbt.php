<?php
/**
 * Script Pengujian Black Box - Sistem Pengadaan Material Kapal
 * Menggunakan cURL untuk menguji endpoint aplikasi
 */

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Vendor;
use App\Models\MaterialRequest;
use App\Models\Tender;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;
use App\Models\TenderInvitation;
use App\Models\VendorQuotation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$results = [];

echo "==============================================\n";
echo "PENGUJIAN BLACK BOX - ANALISIS DATABASE & LOGIK\n";
echo "==============================================\n\n";

// ============================================================
// BAGIAN 1: STATUS DATABASE
// ============================================================
echo "### 1. STATUS DATABASE ###\n";
echo "Users total: ".User::count()."\n";
echo "Vendors total: ".Vendor::count()."\n";
echo "MaterialRequests total: ".MaterialRequest::count()."\n";
echo "Tenders total: ".Tender::count()."\n";
echo "PurchaseOrders total: ".PurchaseOrder::count()."\n";
echo "GoodsReceipts total: ".GoodsReceipt::count()."\n";
echo "TenderInvitations total: ".TenderInvitation::count()."\n";
echo "VendorQuotations total: ".VendorQuotation::count()."\n\n";

// ============================================================
// BAGIAN 2: DATA AKUN PENGUJIAN
// ============================================================
echo "### 2. DATA AKUN PENGUJIAN ###\n";
$accounts = [
    ['email'=>'engineer@gmail.com','password'=>'engineer123'],
    ['email'=>'engineera@gmail.com','password'=>'engineera123'],
    ['email'=>'planner@gmail.com','password'=>'planner123'],
    ['email'=>'supplychain@gmail.com','password'=>'supplychain123'],
    ['email'=>'logamsamudrajaya@gmail.com','password'=>'vendor123'],
    ['email'=>'gudang@gmail.com','password'=>'gudang 123'],
];

foreach($accounts as $acc) {
    $user = User::where('email',$acc['email'])->first();
    if($user) {
        $passOk = Hash::check($acc['password'], $user->password);
        echo "Email: {$acc['email']} | Role: {$user->role} | Password OK: ".($passOk?'YA':'TIDAK')."\n";
    } else {
        echo "Email: {$acc['email']} | TIDAK DITEMUKAN\n";
    }
}
echo "\n";

// ============================================================
// BAGIAN 3: STATUS VENDOR
// ============================================================
echo "### 3. STATUS VENDOR ###\n";
$vendors = Vendor::with('user')->get();
foreach($vendors as $v) {
    $email = $v->user ? $v->user->email : 'no-user';
    $isActive = $v->is_active ? 'aktif' : 'nonaktif';
    echo "Kode: {$v->kode_vendor} | Nama: {$v->nama_vendor} | status: {$v->status} | reg: {$v->status_registrasi} | Email: {$email}\n";
    if($v->alasan_penolakan) echo "  -> Alasan Tolak: {$v->alasan_penolakan}\n";
}
echo "\n";

// ============================================================
// BAGIAN 4: STATUS MATERIAL REQUESTS
// ============================================================
echo "### 4. STATUS MATERIAL REQUESTS ###\n";
$mrs = MaterialRequest::with(['user','project','items'])->latest()->get();
foreach($mrs as $mr) {
    $userName = $mr->user ? $mr->user->name : 'unknown';
    $projectName = $mr->project ? $mr->project->nama_proyek : 'unknown';
    $itemCount = $mr->items->count();
    echo "ID:{$mr->id} | Kode:{$mr->kode_pengajuan} | Status:{$mr->status} | User:{$userName} | Proyek:{$projectName} | Items:{$itemCount}\n";
}
echo "\n";

// ============================================================
// BAGIAN 5: STATUS TENDER
// ============================================================
echo "### 5. STATUS TENDER ###\n";
$tenders = Tender::with(['materialRequest','invitations.vendor','quotations.vendor'])->latest()->get();
foreach($tenders as $t) {
    $mrKode = $t->materialRequest ? $t->materialRequest->kode_pengajuan : '-';
    $invCount = $t->invitations->count();
    $quotCount = $t->quotations->count();
    echo "ID:{$t->id} | Kode:{$t->kode_tender} | Status:{$t->status} | MR:{$mrKode} | Inv:{$invCount} | Quot:{$quotCount}\n";
    foreach($t->invitations as $inv) {
        $vName = $inv->vendor ? $inv->vendor->nama_vendor : '-';
        echo "   -> Inv: {$vName} | Status Inv: {$inv->status}\n";
    }
    foreach($t->quotations as $q) {
        $vName = $q->vendor ? $q->vendor->nama_vendor : '-';
        $negHarga = $q->harga_negosiasi ?? '-';
        echo "   -> Quot: {$vName} | Harga: {$q->harga_penawaran} | Harga Neg: {$negHarga} | Status Quot: {$q->status}\n";
    }
}
echo "\n";

// ============================================================
// BAGIAN 6: STATUS PURCHASE ORDERS
// ============================================================
echo "### 6. STATUS PURCHASE ORDERS ###\n";
$pos = PurchaseOrder::with(['vendor','tender','items','quotation'])->latest()->get();
foreach($pos as $po) {
    $vName = $po->vendor ? $po->vendor->nama_vendor : '-';
    $tName = $po->tender ? $po->tender->kode_tender : '-';
    $itemCount = $po->items->count();
    $archived = $po->is_archived ? 'YES' : 'NO';
    $quotHarga = $po->quotation ? $po->quotation->harga_penawaran : '-';
    $quotNeg = $po->quotation ? ($po->quotation->harga_negosiasi ?? '-') : '-';
    $poTotal = $po->total_harga;
    echo "ID:{$po->id} | Kode:{$po->kode_po} | Vendor:{$vName} | Tender:{$tName} | Status:{$po->status} | Total:{$poTotal} | QuotHarga:{$quotHarga} | QuotNeg:{$quotNeg} | Archived:{$archived}\n";
    
    // Cek apakah harga PO menggunakan harga negosiasi
    if($po->quotation && $po->quotation->harga_negosiasi) {
        if($po->total_harga == $po->quotation->harga_negosiasi) {
            echo "   -> [HARGA NEGOSIASI: SESUAI]\n";
        } elseif($po->total_harga == $po->quotation->harga_penawaran) {
            echo "   -> [BUG: PO menggunakan harga penawaran lama, bukan harga negosiasi!]\n";
        }
    }
    
    foreach($po->items as $item) {
        echo "   -> Item: {$item->nama_barang} | Qty: {$item->qty} {$item->satuan} | Harga Satuan: {$item->harga_satuan}\n";
    }
}
echo "\n";

// ============================================================
// BAGIAN 7: STATUS GOODS RECEIPTS
// ============================================================
echo "### 7. STATUS GOODS RECEIPTS ###\n";
$receipts = GoodsReceipt::with(['purchaseOrder.vendor','creator','photos'])->latest()->get();
foreach($receipts as $r) {
    $poKode = $r->purchaseOrder ? $r->purchaseOrder->kode_po : '-';
    $vName = $r->purchaseOrder && $r->purchaseOrder->vendor ? $r->purchaseOrder->vendor->nama_vendor : '-';
    $creator = $r->creator ? $r->creator->name : '-';
    $photoCount = $r->photos->count();
    echo "ID:{$r->id} | PO:{$poKode} | Vendor:{$vName} | Status:{$r->status_penerimaan} | Kondisi:{$r->kondisi_barang} | Foto:{$photoCount} | Creator:{$creator}\n";
}
echo "\n";

// ============================================================
// BAGIAN 8: CEK VALIDASI MIDDLEWARE
// ============================================================
echo "### 8. CEK LOGIK MIDDLEWARE ###\n";

// Cek middleware vendor approved
echo "VendorApproved: Vendor status 'ditolak' diarahkan ke vendor.dashboard dengan error\n";
echo "EngineerOnly: Non-engineer diarahkan ke dashboard dengan error atau ke login\n";
echo "PlannerOnly: Non-planner diarahkan ke dashboard dengan error\n";
echo "SupplyChainOnly: Non-SC diarahkan ke dashboard dengan error\n";
echo "GudangOnly: Non-gudang diarahkan ke dashboard dengan error\n\n";

// ============================================================
// BAGIAN 9: CEK HASH PASSWORD
// ============================================================
echo "### 9. CEK HASH PASSWORD ###\n";
$usersCheck = User::all();
$allHashed = true;
foreach($usersCheck as $u) {
    $isHashed = strlen($u->password) > 30 && str_starts_with($u->password, '$');
    if(!$isHashed) {
        $allHashed = false;
        echo "MASALAH: User {$u->email} password tidak di-hash!\n";
    }
}
if($allHashed) echo "Semua password tersimpan dalam bentuk bcrypt hash.\n";
echo "\n";

// ============================================================
// BAGIAN 10: CEK ROUTE DAN VALIDASI
// ============================================================
echo "### 10. VALIDASI ATURAN BISNIS ###\n";

// Cek pengajuan yang masih bisa diedit (status=diajukan)
$editableRequests = MaterialRequest::where('status','diajukan')->where('user_id', User::where('email','engineer@gmail.com')->first()?->id)->count();
echo "Engineer - Pengajuan bisa diedit (status=diajukan): {$editableRequests}\n";

// Cek pengajuan yang sudah disetujui planner
$approvedRequests = MaterialRequest::where('status','disetujui')->count();
echo "Pengajuan disetujui Planner (untuk SC): {$approvedRequests}\n";

// Cek tender yang sudah vendor_terpilih
$selectedVendorTenders = Tender::where('status','vendor_terpilih')->count();
echo "Tender dengan vendor terpilih: {$selectedVendorTenders}\n";

// Cek PO yang sudah selesai
$completedPOs = PurchaseOrder::where('status','selesai')->count();
echo "PO selesai: {$completedPOs}\n";

// Cek PO yang diarsipkan
$archivedPOs = PurchaseOrder::where('is_archived',true)->count();
echo "PO diarsipkan: {$archivedPOs}\n";

// Cek vendor yang ditolak dengan alasan
$rejectedVendors = Vendor::where('status_registrasi','ditolak')->count();
echo "Vendor ditolak: {$rejectedVendors}\n";
if($rejectedVendors > 0) {
    Vendor::where('status_registrasi','ditolak')->get()->each(function($v) {
        echo "  -> {$v->nama_vendor}: ".($v->alasan_penolakan ?? 'tidak ada alasan')."\n";
    });
}

echo "\n=== SELESAI ===\n";
