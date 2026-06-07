
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
        // For MySQL, we need to recreate the enum
        DB::statement("ALTER TABLE schedules MODIFY COLUMN type ENUM('lecture', 'lab', 'tutorial', 'exam', 'practical') DEFAULT 'lecture'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE schedules MODIFY COLUMN type ENUM('lecture', 'lab', 'tutorial', 'exam') DEFAULT 'lecture'");
    }
};
