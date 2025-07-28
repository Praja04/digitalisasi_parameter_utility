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
        Schema::create('user_forklift_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('forklift_id')->constrained('forklifts')->onDelete('cascade');
            $table->boolean('is_primary')->default(false); // true = operator utama
            $table->date('assigned_date')->default(now());
            $table->foreignId('assigned_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index untuk performance
            $table->index(['user_id', 'is_active']);
            $table->index(['forklift_id', 'is_primary']);

            // Constraint: hanya boleh ada 1 primary operator per forklift yang aktif
            $table->unique(['forklift_id', 'is_primary'], 'unique_primary_per_forklift')
                ->where('is_primary', true)
                ->where('is_active', true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_forklift_assignments');
    }
};
