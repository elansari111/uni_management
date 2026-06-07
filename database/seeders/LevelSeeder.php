<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Licence 1',
                'code' => 'L1',
                'description' => 'Première année de licence',
                'order' => 1,
            ],
            [
                'name' => 'Licence 2',
                'code' => 'L2',
                'description' => 'Deuxième année de licence',
                'order' => 2,
            ],
            [
                'name' => 'Licence 3',
                'code' => 'L3',
                'description' => 'Troisième année de licence',
                'order' => 3,
            ],
            [
                'name' => 'Master 1',
                'code' => 'M1',
                'description' => 'Première année de master',
                'order' => 4,
            ],
            [
                'name' => 'Master 2',
                'code' => 'M2',
                'description' => 'Deuxième année de master',
                'order' => 5,
            ],
        ];

        foreach ($levels as $level) {
            \App\Models\Level::firstOrCreate(
                ['code' => $level['code']],
                $level
            );
        }
    }
}
