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
        Schema::create('readsensors_st53', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->timestamp('waktu')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->float('A1');
            $table->float('A2');
            $table->float('A3');
            $table->float('A4');
            $table->float('A5');
            $table->float('B1');
            $table->float('B2');
            $table->float('B3');
            $table->float('B4');
            $table->float('B5');
            $table->float('C1');
            $table->float('C2');
            $table->float('C3');
            $table->float('C4');
            $table->float('C5');
            $table->float('D1');
            $table->float('D2');
            $table->float('D3');
            $table->float('D4');
            $table->float('D5');
            $table->float('DTS');
            $table->float('DTP3');
            $table->float('DTP2');
            $table->float('DTP1');
            $table->float('DTB');
            $table->float('MSD1');
            $table->float('MSD2');
            $table->float('JERIKEN');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readsensors_st53');
    }
};
