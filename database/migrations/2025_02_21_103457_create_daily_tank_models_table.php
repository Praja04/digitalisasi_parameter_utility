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
        Schema::create('readsensors_dailytank', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->timestamp('waktu')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->float('DT_RO');
            $table->float('DT_Salt');
            $table->float('DT_SoySauceA');
            $table->float('DT_SoySauceB');
            $table->float('DT_SoySauceC');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readsensors_dailytank');
    }
};
