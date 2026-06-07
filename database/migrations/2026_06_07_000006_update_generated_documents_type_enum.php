<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE generated_documents MODIFY COLUMN type ENUM('transcript','certificate','attestation','grade_report','other','work_attestation','mission_order')");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE generated_documents MODIFY COLUMN type ENUM('transcript','certificate','attestation','grade_report','other')");
    }
};
