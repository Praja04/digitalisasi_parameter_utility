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
        Schema::create('forklifts', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_unit', 10)->unique(); // FL-001, FL-002, dst
            $table->enum('departemen', ['warehouse', 'produksi'])->default('warehouse');
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->text('description')->nullable(); // deskripsi forklift
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forklifts');
    }
};
