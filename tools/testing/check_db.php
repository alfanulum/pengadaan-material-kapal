<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\MaterialRequest;
use App\Models\Tender;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;

echo "=== USERS ===\n";
$users = User::select('id','name','email','role')->get();
foreach($users as $u){
    echo $u->id.' | '.$u->role.' | '.$u->email."\n";
}

echo "\n=== VENDORS ===\n";
$vendors = Vendor::with('user')->get();
foreach($vendors as $v){
    $email = $v->user ? $v->user->email : 'no-user';
    echo $v->kode_vendor.' | status_reg:'.$v->status_registrasi.' | is_active:'.$v->is_active.' | '.$email."\n";
}

echo "\n=== COUNTS ===\n";
echo "Projects: ".Project::count()."\n";
echo "MaterialRequests: ".MaterialRequest::count()."\n";
echo "Tenders: ".Tender::count()."\n";
echo "PurchaseOrders: ".PurchaseOrder::count()."\n";
echo "GoodsReceipts: ".GoodsReceipt::count()."\n";
