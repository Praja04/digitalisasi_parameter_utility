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
    public function up()
    {
        for ($i = 1; $i <= 8; $i++) {
            Schema::create("dissolver{$i}", function (Blueprint $table) {
                $table->id();
                $table->string('Batch', 15);
                $table->string('Varian', 5);
                $table->double('PO_Masak');
                $table->double('No_Formulasi');
                $table->string('Status_GGA', 50);
                $table->double('Gula');
                $table->double('NaCl_GGA');
                $table->double('Brix_GGA');
                $table->double('Warna_GGA');
                $table->double('Organo_GGA');
                $table->string('Status_GGAS', 50);
                $table->double('NaCl_GGAS');
                $table->double('Brix_GGAS');
                $table->double('Warna_GGAS');
                $table->double('Organo_GGAS');
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            });
        }
    }

    public function down()
    {
        for ($i = 1; $i <= 8; $i++) {
            Schema::dropIfExists("dissolver{$i}");
        }
    }
};
