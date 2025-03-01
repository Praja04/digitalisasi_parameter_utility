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
        Schema::create('readsensors_pasteurisasi2', function (Blueprint $table) {
            $table->id(); // Auto Increment Primary Key
            $table->timestamp('waktu')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->text('SpeedPompaMixing');
            $table->float('PressureMixing');
            $table->float('SuhuPreheating');
            $table->float('LevelBT1');
            $table->float('SpeedPumpBT1');
            $table->float('LevelVD');
            $table->float('SpeedPumpVD');
            $table->float('FlowrateAM');
            $table->float('Flowrate');
            $table->float('SuhuHeating');
            $table->float('SuhuHolding');
            $table->float('SuhuPrecooling');
            $table->float('LevelBT2');
            $table->float('SpeedPumpBT2');
            $table->float('PressureBT2');
            $table->float('SuhuCooling');
            $table->float('MV1');
            $table->float('MV2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readsensors_pasteurisasi2');
    }
};
