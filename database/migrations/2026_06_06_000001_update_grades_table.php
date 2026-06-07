<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['grade_type', 'score', 'max_score', 'date', 'comments']);
            $table->decimal('cc1', 5, 2)->nullable();
            $table->decimal('cc2', 5, 2)->nullable();
            $table->decimal('exam', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->text('remarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->enum('grade_type', ['cc1', 'cc2', 'exam', 'final']);
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2)->default(20);
            $table->date('date');
            $table->text('comments')->nullable();
            $table->dropColumn(['cc1', 'cc2', 'exam', 'final_grade', 'remarks']);
        });
    }
};
