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
        Schema::create('readsensors_olahsari', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->timestamp('waktu')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->float('TempMixer1');
            $table->float('LC_Mixer1');
            $table->float('TempMixer2');
            $table->float('LC_Mixer2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readsensors_olahsari');
    }
};
