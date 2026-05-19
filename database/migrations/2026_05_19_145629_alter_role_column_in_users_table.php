<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter enum to include super_admin
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'customer') DEFAULT 'customer'");
        
        // Convert existing admins to super_admin to maintain full access
        DB::statement("UPDATE users SET role = 'super_admin' WHERE role = 'admin'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back (note: this might fail if there are 'super_admin' users, so we update them first)
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'super_admin'");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'customer') DEFAULT 'customer'");
    }

};
