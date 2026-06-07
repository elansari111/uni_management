<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_logs', function (Blueprint $table) {
            $table->string('title')->nullable()->after('module_id');
            $table->text('summary')->nullable()->after('title');
            // Keep objective, nature, notes for backward compatibility
        });
    }

    public function down(): void
    {
        Schema::table('lesson_logs', function (Blueprint $table) {
            $table->dropColumn(['title', 'summary']);
        });
    }
};
