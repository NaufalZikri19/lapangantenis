<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all super_admin users to admin
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'super_admin'");

        // Alter enum to remove super_admin
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'customer') DEFAULT 'customer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back super_admin to enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'customer') DEFAULT 'customer'");

        // Note: We can't definitively know which admin was a super_admin before,
        // so we leave them as admin in the down method, or we could just make everyone super_admin
        // DB::statement("UPDATE users SET role = 'super_admin' WHERE role = 'admin'");
    }
};
