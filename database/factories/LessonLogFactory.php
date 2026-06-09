<?php

namespace Database\Factories;

use App\Models\LessonLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LessonLog>
 */
class LessonLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Introduction à Java', 'Les Classes et Objets', 'Héritage et Polymorphisme',
            'SQL - Les Jointures', 'Conception de Bases de Données', 'SQL Avancé',
            'HTML & CSS', 'JavaScript - DOM', 'PHP - POO',
            'Modèle OSI', 'TCP/IP', 'Réseaux Locaux',
            'Algorithmique - Tri', 'Algorithmique - Recherche', 'Analyse de Complexité',
        ];
        $summaries = [
            'Introduction aux concepts de base de Java et à la syntaxe.',
            'Étude des classes et objets en programmation orientée objet.',
            'Introduction à l\'héritage et au polymorphisme.',
            'Les jointures SQL pour combiner les tables.',
            'Conception de bases de données avec le modèle entité-association.',
            'SQL avancé : fonctions, procédures stockées, triggers.',
            'Introduction à HTML et CSS pour la création de sites web.',
            'Manipulation du DOM en JavaScript.',
            'Programmation orientée objet en PHP.',
            'Le modèle OSI et les couches réseaux.',
            'Le protocole TCP/IP.',
            'Réseaux locaux et topologies.',
            'Algorithmes de tri.',
            'Algorithmes de recherche.',
            'Analyse de la complexité algorithmique.',
        ];
        $objectives = [
            'Comprendre les concepts de base de Java.',
            'Savoir créer des classes et des objets.',
            'Maîtriser l\'héritage et le polymorphisme.',
            'Maîtriser les jointures SQL.',
            'Savoir concevoir une base de données.',
            'Utiliser les fonctionnalités avancées de SQL.',
            'Créer des pages web statiques avec HTML et CSS.',
            'Manipuler le DOM en JavaScript.',
            'Développer des applications web en PHP.',
            'Comprendre le modèle OSI.',
            'Savoir fonctionne le protocole TCP/IP.',
            'Comprendre les réseaux locaux.',
            'Implémenter des algorithmes de tri.',
            'Implémenter des algorithmes de recherche.',
            'Analyser la complexité des algorithmes.',
        ];
        $key = array_rand($titles);
        $timeSlots = [['start' => '08:00', 'end' => '10:00'], ['start' => '10:00', 'end' => '12:00'], ['start' => '14:00', 'end' => '16:00'], ['start' => '16:00', 'end' => '18:00']];
        $slot = $timeSlots[array_rand($timeSlots)];

        return [
            'teacher_id' => \App\Models\Teacher::inRandomOrder()->first()?->id ?? \App\Models\Teacher::factory(),
            'module_id' => \App\Models\Module::inRandomOrder()->first()?->id ?? \App\Models\Module::factory(),
            'classroom_id' => \App\Models\Classroom::inRandomOrder()->first()?->id ?? \App\Models\Classroom::factory(),
            'date' => fake()->date(),
            'start_time' => $slot['start'],
            'end_time' => $slot['end'],
            'title' => $titles[$key],
            'summary' => $summaries[$key],
            'objective' => $objectives[$key],
            'nature' => fake()->randomElement(['Cours', 'TD', 'TP']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
