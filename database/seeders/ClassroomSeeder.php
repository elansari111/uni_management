<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classrooms = [
            [
                'name' => 'Amphithéâtre A1',
                'code' => 'AMP-A1',
                'capacity' => 120,
                'building' => 'A',
                'floor' => 0,
                'equipment' => ['projector', 'computer', 'sound_system', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Salle Informatique 1',
                'code' => 'INFO-1',
                'capacity' => 30,
                'building' => 'B',
                'floor' => 1,
                'equipment' => ['projector', 'computer', 'whiteboard', 'sound_system'],
                'status' => 'available',
            ],
            [
                'name' => 'Salle Informatique 2',
                'code' => 'INFO-2',
                'capacity' => 30,
                'building' => 'B',
                'floor' => 1,
                'equipment' => ['projector', 'computer', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Salle de TD 101',
                'code' => 'TD-101',
                'capacity' => 35,
                'building' => 'A',
                'floor' => 1,
                'equipment' => ['projector', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Salle de TD 102',
                'code' => 'TD-102',
                'capacity' => 35,
                'building' => 'A',
                'floor' => 1,
                'equipment' => ['projector', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Salle de TD 201',
                'code' => 'TD-201',
                'capacity' => 40,
                'building' => 'B',
                'floor' => 2,
                'equipment' => ['projector', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Laboratoire Réseaux',
                'code' => 'LAB-RESEAU',
                'capacity' => 25,
                'building' => 'C',
                'floor' => 0,
                'equipment' => ['projector', 'computer', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Laboratoire Electronique',
                'code' => 'LAB-ELEC',
                'capacity' => 20,
                'building' => 'C',
                'floor' => 1,
                'equipment' => ['projector', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Amphithéâtre B1',
                'code' => 'AMP-B1',
                'capacity' => 100,
                'building' => 'B',
                'floor' => 0,
                'equipment' => ['projector', 'computer', 'sound_system', 'whiteboard'],
                'status' => 'available',
            ],
            [
                'name' => 'Salle de Réunion 1',
                'code' => 'REUNION-1',
                'capacity' => 15,
                'building' => 'A',
                'floor' => 3,
                'equipment' => ['projector', 'computer', 'whiteboard'],
                'status' => 'available',
            ],
        ];

        foreach ($classrooms as $classroom) {
            \App\Models\Classroom::firstOrCreate(
                ['code' => $classroom['code']],
                $classroom
            );
        }
    }
}
