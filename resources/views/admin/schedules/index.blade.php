@extends('layouts.app')

@section('title', 'Gestion des Emplois du Temps - PFM')
@section('header_title', 'Gestion des Emplois du Temps')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-slate-800">Créneaux Horaires Enregistrés</h3>
        <a href="{{ route('admin.schedules.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-all">
            + Planifier un Cours
        </a>
    </div>

    <!-- Schedule Table -->
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Jour</th>
                        <th class="px-6 py-4">Heure de Début</th>
                        <th class="px-6 py-4">Heure de Fin</th>
                        <th class="px-6 py-4">Module</th>
                        <th class="px-6 py-4">Enseignant</th>
                        <th class="px-6 py-4">Groupe</th>
                        <th class="px-6 py-4">Salle</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold capitalize text-slate-900">{{ $schedule->day_of_week }}</td>
                            <td class="px-6 py-4">{{ $schedule->start_time }}</td>
                            <td class="px-6 py-4">{{ $schedule->end_time }}</td>
                            <td class="px-6 py-4 font-medium text-indigo-600">{{ $schedule->module?->name }}</td>
                            <td class="px-6 py-4">{{ $schedule->module?->teacher?->name ?? 'Non affecté' }}</td>
                            <td class="px-6 py-4 font-medium">{{ $schedule->module?->group?->name ?? 'Tous' }}</td>
                            <td class="px-6 py-4">{{ $schedule->classroom?->name }} ({{ $schedule->classroom?->building }})</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 text-xs rounded font-medium
                                    {{ $schedule->type === 'lecture' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $schedule->type === 'tutorial' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $schedule->type === 'practical' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $schedule->type === 'exam' ? 'bg-rose-100 text-rose-800' : '' }}
                                ">
                                    {{ $schedule->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Retirer ce cours de la planification ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-950 font-semibold cursor-pointer">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-slate-400">Aucun cours planifié pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
