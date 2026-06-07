<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE administrative_requests MODIFY COLUMN type ENUM('transcript','certificate','attestation','other','work_attestation','mission_order')");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE administrative_requests MODIFY COLUMN type ENUM('transcript','certificate','attestation','other')");
    }
};
