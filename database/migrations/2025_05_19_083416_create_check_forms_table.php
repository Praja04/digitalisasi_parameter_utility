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
        Schema::create('check_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forklift_id')->constrained('forklifts')->onDelete('cascade');
            $table->enum('shift', ['Shift 1', 'Shift 2', 'Shift 3']);
            $table->date('tanggal');
            $table->string('operator_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_forms');
    }
};
