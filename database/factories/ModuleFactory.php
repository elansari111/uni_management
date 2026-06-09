<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modules = [
            ['name' => 'Programmation Orientée Objet', 'code' => 'POO201', 'credits' => 6, 'level' => 'L2', 'semester' => 'S1', 'description' => 'Apprentissage de la programmation orientée objet avec Java.'],
            ['name' => 'Structures de Données', 'code' => 'SD201', 'credits' => 5, 'level' => 'L2', 'semester' => 'S1', 'description' => 'Étude des structures de données fondamentales (tableaux, listes, piles, files, arbres, graphes).'],
            ['name' => 'Bases de Données', 'code' => 'BDD301', 'credits' => 6, 'level' => 'L3', 'semester' => 'S1', 'description' => 'Conception et implémentation de bases de données relationnelles avec SQL.'],
            ['name' => 'Développement Web', 'code' => 'WEB301', 'credits' => 5, 'level' => 'L3', 'semester' => 'S1', 'description' => 'Développement d\'applications web avec HTML, CSS, JavaScript et PHP.'],
            ['name' => 'Réseaux Informatiques', 'code' => 'RES301', 'credits' => 5, 'level' => 'L3', 'semester' => 'S2', 'description' => 'Étude des réseaux informatiques et protocoles TCP/IP.'],
            ['name' => 'Intelligence Artificielle', 'code' => 'IA401', 'credits' => 6, 'level' => 'M1', 'semester' => 'S1', 'description' => 'Introduction à l\'intelligence artificielle et à l\'apprentissage machine.'],
            ['name' => 'Génie Logiciel', 'code' => 'GL401', 'credits' => 5, 'level' => 'M1', 'semester' => 'S1', 'description' => 'Méthodologies de développement logiciel et gestion de projets.'],
            ['name' => 'Algorithmique Avancée', 'code' => 'AA301', 'credits' => 6, 'level' => 'L3', 'semester' => 'S2', 'description' => 'Algorithmique complexe et analyse de la complexité.'],
            ['name' => 'Systèmes d\'Exploitation', 'code' => 'SE201', 'credits' => 5, 'level' => 'L2', 'semester' => 'S2', 'description' => 'Principes fondamentaux des systèmes d\'exploitation.'],
            ['name' => 'Web Mobile', 'code' => 'WM401', 'credits' => 5, 'level' => 'M1', 'semester' => 'S2', 'description' => 'Développement d\'applications mobiles.'],
            ['name' => 'Introduction à la Programmation', 'code' => 'PROG101', 'credits' => 6, 'level' => 'L1', 'semester' => 'S1', 'description' => 'Introduction à la programmation avec Python.'],
            ['name' => 'Mathématiques pour Informatique', 'code' => 'MATH102', 'credits' => 5, 'level' => 'L1', 'semester' => 'S2', 'description' => 'Mathématiques fondamentales pour l\'informatique.'],
        ];
        
        // Try to find a module that doesn't exist yet
        $existingCodes = \App\Models\Module::pluck('code')->toArray();
        $availableModules = array_filter($modules, function($module) use ($existingCodes) {
            return !in_array($module['code'], $existingCodes);
        });
        
        if (!empty($availableModules)) {
            $module = fake()->randomElement($availableModules);
        } else {
            // Generate a dynamic module if all are used
            $randomNum = fake()->unique()->randomNumber(3);
            $module = [
                'name' => 'Module ' . $randomNum,
                'code' => 'MOD' . $randomNum,
                'credits' => fake()->numberBetween(3, 6),
                'level' => fake()->randomElement(['L1', 'L2', 'L3', 'M1', 'M2']),
                'semester' => fake()->randomElement(['S1', 'S2']),
                'description' => fake()->sentence(10),
            ];
        }

        return [
            'name' => $module['name'],
            'code' => $module['code'],
            'description' => $module['description'],
            'credits' => $module['credits'],
            'teacher_id' => function () {
                $teacherUser = \App\Models\User::whereHas('role', function($q) {
                    $q->where('slug', 'teacher');
                })->inRandomOrder()->first();
                return $teacherUser ? $teacherUser->id : null;
            },
            'group_id' => \App\Models\Group::inRandomOrder()->first()?->id ?? \App\Models\Group::factory(),
            'level' => $module['level'],
            'semester' => $module['semester'],
            'status' => 'active',
        ];
    }
}
