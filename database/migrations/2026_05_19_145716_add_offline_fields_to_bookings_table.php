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
        Schema::table('bookings', function (Blueprint $table) {
            // Make user_id nullable for offline/blocked bookings
            $table->foreignId('user_id')->nullable()->change();
            
            // Add guest name for offline walk-ins
            $table->string('guest_name')->nullable()->after('user_id');
            
            // Add booking type to differentiate source and purpose
            $table->enum('booking_type', ['online', 'offline', 'block'])->default('online')->after('guest_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->dropColumn(['guest_name', 'booking_type']);
        });
    }
};
