<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE generated_documents DROP FOREIGN KEY generated_documents_student_id_foreign");
        DB::statement("ALTER TABLE generated_documents MODIFY student_id BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE generated_documents ADD CONSTRAINT generated_documents_student_id_foreign FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE");

        DB::statement("ALTER TABLE generated_documents ADD COLUMN teacher_id BIGINT UNSIGNED NULL AFTER student_id");
        DB::statement("ALTER TABLE generated_documents ADD INDEX generated_documents_teacher_id_index (teacher_id)");
        DB::statement("ALTER TABLE generated_documents ADD CONSTRAINT generated_documents_teacher_id_foreign FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE generated_documents DROP FOREIGN KEY generated_documents_teacher_id_foreign");
        DB::statement("ALTER TABLE generated_documents DROP INDEX generated_documents_teacher_id_index");
        DB::statement("ALTER TABLE generated_documents DROP COLUMN teacher_id");

        DB::statement("ALTER TABLE generated_documents DROP FOREIGN KEY generated_documents_student_id_foreign");
        DB::statement("ALTER TABLE generated_documents MODIFY student_id BIGINT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE generated_documents ADD CONSTRAINT generated_documents_student_id_foreign FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE");
    }
};
