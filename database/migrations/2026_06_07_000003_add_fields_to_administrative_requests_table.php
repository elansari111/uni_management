<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('administrative_requests', function (Blueprint $table) {
            $table->string('destination')->nullable()->after('description');
            $table->date('start_date')->nullable()->after('destination');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('purpose')->nullable()->after('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('administrative_requests', function (Blueprint $table) {
            $table->dropColumn(['destination', 'start_date', 'end_date', 'purpose']);
        });
    }
};
