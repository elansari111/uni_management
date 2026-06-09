<?php

namespace Database\Seeders;

use App\Models\LessonLog;
use Illuminate\Database\Seeder;

class LessonLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LessonLog::factory()->count(20)->create();
    }
}
