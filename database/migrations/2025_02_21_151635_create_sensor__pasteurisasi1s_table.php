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
        Schema::create('db_excel_pasteurisasi1', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('Nama_File', 255);
            $table->string('Deskripsi', 255);
            $table->binary('Excel');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('readparameters_pasteurisasi1', function (Blueprint $table) {
            $table->id();
            $table->timestamp('Waktu')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->text('SpeedPompaMixing');
            $table->text('PressureMixing');
            $table->text('SuhuPreheating');
            $table->text('LevelBT1');
            $table->text('SpeedPumpBT1');
            $table->text('LevelVD');
            $table->text('SpeedPumpVD');
            $table->text('Flowrate');
            $table->text('SuhuHeating');
            $table->text('SuhuHolding');
            $table->text('SuhuPrecooling');
            $table->text('LevelBT2');
            $table->text('SpeedPumpBT2');
            $table->text('PressureBT2');
            $table->text('SuhuCooling');
            $table->text('PressToPasteur');
            $table->text('PressVDHH');
            $table->text('PressVDLL');
            $table->text('MixingAM');
            $table->text('BT1AM');
            $table->text('VDAM');
            $table->text('PCV1');
            $table->text('TimeDivert');
            $table->string('Mode', 6)->nullable();
            $table->string('Varian', 25)->nullable();
            $table->string('Batch', 25)->nullable();
            $table->string('Storage', 25)->nullable();
        });

        Schema::create('readsensors_pasteurisasi1', function (Blueprint $table) {
            $table->id();
            $table->timestamp('Waktu')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->float('SpeedPompaMixing')->nullable();
            $table->float('PressureMixing')->nullable();
            $table->float('SuhuPreheating')->nullable();
            $table->float('LevelBT1')->nullable();
            $table->float('SpeedPumpBT1')->nullable();
            $table->float('LevelVD')->nullable();
            $table->float('SpeedPumpVD')->nullable();
            $table->float('Flowrate')->nullable();
            $table->float('SuhuHeating')->nullable();
            $table->float('SuhuHolding')->nullable();
            $table->float('SuhuPrecooling')->nullable();
            $table->float('LevelBT2')->nullable();
            $table->float('SpeedPumpBT2')->nullable();
            $table->float('PressureBT2')->nullable();
            $table->float('SuhuCooling')->nullable();
            $table->float('PressToPasteur')->nullable();
            $table->float('PressVDHH')->nullable();
            $table->float('PressVDLL')->nullable();
            $table->float('MixingAM')->nullable();
            $table->float('BT1AM')->nullable();
            $table->float('VDAM')->nullable();
            $table->float('PCV1')->nullable();
            $table->float('TimeDivert')->nullable();
            $table->string('Mode', 6)->nullable();
            $table->string('Varian', 25)->nullable();
            $table->string('Batch', 25)->nullable();
            $table->string('Storage', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_excel');
        Schema::dropIfExists('readparameters');
        Schema::dropIfExists('readsensors');
    }
};
