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
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first if they exist
            if (Schema::hasColumn('users', 'province_id')) {
                $table->dropForeign(['province_id']);
            }
            if (Schema::hasColumn('users', 'regency_id')) {
                $table->dropForeign(['regency_id']);
            }

            // Drop unneeded columns
            $columnsToDrop = [
                'address_ktp',
                'district',
                'province_id',
                'regency_id',
                'nationality',
                'birth_date',
                'birth_place',
                'gender',
                'marital_status',
                'religion',
                'province'
            ];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Add phone and address if they don't exist
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->text('address_ktp')->nullable();
            $table->string('district')->nullable();
            $table->string('nationality')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->enum('gender', ['pria', 'wanita'])->nullable();
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('province')->nullable();
        });
    }
};
