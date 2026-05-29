<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('booking_id_origin')->nullable()->comment('ID of the canceled booking that generated this voucher');
            $table->string('code')->unique();
            $table->integer('amount');
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();

            // Note: Not setting a strict foreign key constraint on booking_id_origin 
            // in case the booking is hard deleted, but ideally it shouldn't be.
            $table->foreign('booking_id_origin')->references('id')->on('bookings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
