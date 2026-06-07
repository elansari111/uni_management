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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Licence 1, Licence 2, Master 1, Master 2
            $table->string('code')->unique(); // e.g., L1, L2, M1, M2
            $table->text('description')->nullable();
            $table->integer('order')->default(0); // For ordering levels
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
