<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bb_steam_boiler', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->float('bb_steam');
            $table->float('AvgBatubara');
            $table->float('AvgSteam');
            $table->unique('waktu');
        });

        // Schema::create('form_boiler', function (Blueprint $table) {
        //     $table->id();
        //     $table->longBlob('pdf_file')->nullable();
        //     $table->string('file_name', 255);
        //     $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        // });

        Schema::create('readsensors_boiler', function (Blueprint $table) {
            $table->id();
            $table->timestamp('waktu')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('LevelFeedWater')->nullable();
            $table->float('PVSteam')->nullable();
            $table->float('FeedPressure')->nullable();
            $table->float('LHGuiloutine')->nullable();
            $table->float('RHGuiloutine')->nullable();
            $table->float('LHTemp')->nullable();
            $table->float('RHTemp')->nullable();
            $table->float('IDFan')->nullable();
            $table->float('LHFDFan')->nullable();
            $table->float('RHFDFan')->nullable();
            $table->float('LHStoker')->nullable();
            $table->float('RHStoker')->nullable();
            $table->float('WaterPump1')->nullable();
            $table->float('WaterPump2')->nullable();
            $table->float('InletWaterFlow')->nullable();
            $table->float('OutletSteamFlow')->nullable();
            $table->float('SuhuFeedTank')->nullable();
            $table->float('O2')->nullable();
            $table->float('CO2')->nullable();
            $table->float('Batubara_FK')->notNullable();
            $table->float('Steam_FK')->notNullable();
        });

        Schema::create('sensors_boiler', function (Blueprint $table) {
            $table->id();
            $table->timestamp('waktu')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('Batubara');
            $table->float('Steam');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bb_steam_boiler');
        // Schema::dropIfExists('form_boiler');
        Schema::dropIfExists('readsensors_boiler');
        Schema::dropIfExists('sensors_boiler');
    }
};
