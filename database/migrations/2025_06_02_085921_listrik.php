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
        // 1. Tabel master session per tanggal & jam
        Schema::create('power_log_sessions', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('operator');
            $table->text('ttd_path')->nullable();
            $table->timestamps();
        });

        // 2. Tabel panel per session
        Schema::create('power_log_panels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('power_log_sessions')->onDelete('cascade');
            $table->enum('panel_type', ['MDP', 'SDP']);
            $table->unsignedInteger('panel_number')->default(0); // 0 untuk MDP, 1-14 untuk SDP
            $table->timestamps();
        });

        // 3. Tabel nilai per panel (V-AVG, I-Avg, P-Tol, E-Del)
        Schema::create('power_log_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panel_id')->constrained('power_log_panels')->onDelete('cascade');
            $table->enum('type', ['V-AVG', 'I-Avg', 'P-Tol', 'E-Del']);
            $table->float('value')->nullable();
            $table->string('satuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('power_log_readings');
        Schema::dropIfExists('power_log_panels');
        Schema::dropIfExists('power_log_sessions');
        }
};
