<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$k = $app->make(Illuminate\Contracts\Console\Kernel::class);
$k->bootstrap();

use App\Models\User;

// Test 1: new User() dengan role di-set langsung
$u = new User();
$u->role = 'admin';
echo "Test 1 - Direct set role:\n";
echo "  role: " . $u->role . "\n";
echo "  isAdmin(): " . ($u->isAdmin() ? 'true' : 'false') . "\n\n";

// Test 2: new User() dengan fill
$u2 = new User(['role' => 'admin']);
echo "Test 2 - Fill constructor:\n";
echo "  role: " . ($u2->role ?? 'NULL') . "\n";
echo "  fillable: " . implode(', ', $u2->getFillable()) . "\n";
// role is not in fillable!
echo "  isAdmin(): " . ($u2->isAdmin() ? 'true' : 'false') . "\n\n";

// Test 3: super_admin
$u3 = new User();
$u3->role = 'super_admin';
echo "Test 3 - super_admin direct set:\n";
echo "  role: " . $u3->role . "\n";
echo "  isAdmin(): " . ($u3->isAdmin() ? 'true' : 'false') . "\n";
echo "  isSuperAdmin(): " . ($u3->isSuperAdmin() ? 'true' : 'false') . "\n\n";

// Test 4: customer
$u4 = new User();
$u4->role = 'customer';
echo "Test 4 - customer:\n";
echo "  role: " . $u4->role . "\n";
echo "  isAdmin(): " . ($u4->isAdmin() ? 'true' : 'false') . "\n";
echo "  isCustomer(): " . ($u4->isCustomer() ? 'true' : 'false') . "\n\n";

// Test 5: Dari database
$dbAdmin = User::where('role', 'admin')->orWhere('role', 'super_admin')->first();
if ($dbAdmin) {
    echo "Test 5 - Admin dari DB:\n";
    echo "  email: " . $dbAdmin->email . "\n";
    echo "  role: " . $dbAdmin->role . "\n";
    echo "  isAdmin(): " . ($dbAdmin->isAdmin() ? 'true' : 'false') . "\n";
    echo "  isSuperAdmin(): " . ($dbAdmin->isSuperAdmin() ? 'true' : 'false') . "\n\n";
} else {
    echo "Test 5: Tidak ada admin di DB\n\n";
}

echo ">>> Diagnosa: 'role' tidak ada di \$fillable, sehingga new User(['role'=>'admin']) tidak mengisi role!\n";
echo ">>> Fillable User: " . implode(', ', (new User())->getFillable()) . "\n";
