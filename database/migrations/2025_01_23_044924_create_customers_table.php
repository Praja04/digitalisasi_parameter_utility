<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('user_id', 20)->primary(); // ID customer
            $table->string('name');
            $table->string('email');
            $table->enum('status', ['NEW CUSTOMER', 'LOYAL CUSTOMER']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
