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
        Schema::create('check_form_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('check_form_id')->constrained('check_forms')->onDelete('cascade');
            $table->foreignId('check_item_id')->constrained('check_items')->onDelete('cascade');
            $table->string('condition_value');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_form_items');
    }
};
