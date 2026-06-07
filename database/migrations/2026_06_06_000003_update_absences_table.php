<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->enum('type', ['present', 'absent', 'late', 'excused'])->default('absent')->after('date');
            $table->dropColumn('status');
            $table->enum('status', ['pending', 'justified', 'unjustified'])->default('unjustified')->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']);
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('absent');
        });
    }
};
