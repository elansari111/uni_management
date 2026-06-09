<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Groupe A - L3 Informatique',
                'code' => 'L3-INFO-A',
                'description' => 'Groupe A de la 3ème année Licence Informatique',
                'capacity' => 30,
                'level_id' => 3,
            ],
            [
                'name' => 'Groupe B - L3 Informatique',
                'code' => 'L3-INFO-B',
                'description' => 'Groupe B de la 3ème année Licence Informatique',
                'capacity' => 30,
                'level_id' => 3,
            ],
            [
                'name' => 'Groupe A - L2 Informatique',
                'code' => 'L2-INFO-A',
                'description' => 'Groupe A de la 2ème année Licence Informatique',
                'capacity' => 35,
                'level_id' => 2,
            ],
            [
                'name' => 'Groupe B - L2 Informatique',
                'code' => 'L2-INFO-B',
                'description' => 'Groupe B de la 2ème année Licence Informatique',
                'capacity' => 35,
                'level_id' => 2,
            ],
            [
                'name' => 'Groupe A - M1 Informatique',
                'code' => 'M1-INFO-A',
                'description' => 'Groupe A de la 1ère année Master Informatique',
                'capacity' => 25,
                'level_id' => 4,
            ],
        ];

        foreach ($groups as $group) {
            \App\Models\Group::firstOrCreate(
                ['code' => $group['code']],
                $group
            );
        }
    }
}
