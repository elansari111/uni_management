<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulesList = [
            [
                'name' => 'Programmation Orientée Objet',
                'code' => 'POO201',
                'description' => 'Apprentissage de la programmation orientée objet avec Java.',
                'credits' => 6,
                'level' => 'L2',
                'semester' => 'S1',
                'status' => 'active',
            ],
            [
                'name' => 'Structures de Données',
                'code' => 'SD201',
                'description' => 'Étude des structures de données fondamentales.',
                'credits' => 5,
                'level' => 'L2',
                'semester' => 'S1',
                'status' => 'active',
            ],
            [
                'name' => 'Bases de Données',
                'code' => 'BDD301',
                'description' => 'Conception et implémentation de bases de données relationnelles avec SQL.',
                'credits' => 6,
                'level' => 'L3',
                'semester' => 'S1',
                'status' => 'active',
            ],
            [
                'name' => 'Développement Web',
                'code' => 'WEB301',
                'description' => 'Développement d\'applications web.',
                'credits' => 5,
                'level' => 'L3',
                'semester' => 'S1',
                'status' => 'active',
            ],
            [
                'name' => 'Réseaux Informatiques',
                'code' => 'RES301',
                'description' => 'Étude des réseaux informatiques et protocoles TCP/IP.',
                'credits' => 5,
                'level' => 'L3',
                'semester' => 'S2',
                'status' => 'active',
            ],
            [
                'name' => 'Intelligence Artificielle',
                'code' => 'IA401',
                'description' => 'Introduction à l\'intelligence artificielle et à l\'apprentissage machine.',
                'credits' => 6,
                'level' => 'M1',
                'semester' => 'S1',
                'status' => 'active',
            ],
            [
                'name' => 'Génie Logiciel',
                'code' => 'GL401',
                'description' => 'Méthodologies de développement logiciel et gestion de projets.',
                'credits' => 5,
                'level' => 'M1',
                'semester' => 'S1',
                'status' => 'active',
            ],
        ];

        foreach ($modulesList as $moduleData) {
            $module = Module::firstOrCreate(
                ['code' => $moduleData['code']],
                array_merge($moduleData, [
                    'teacher_id' => \App\Models\User::whereHas('role', function($q) {
                        $q->where('slug', 'teacher');
                    })->inRandomOrder()->first()?->id,
                    'group_id' => \App\Models\Group::inRandomOrder()->first()?->id,
                ])
            );
        }


    }
}
