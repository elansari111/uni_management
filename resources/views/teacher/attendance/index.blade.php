@extends('layouts.app')

@section('title', 'Suivi des Absences - PFM')
@section('header_title', 'Registre des Absences')

@section('content')
<div class="space-y-6">
    <!-- Filters / Selectors -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
        <form method="GET" action="{{ route('teacher.attendance.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1">
                <label for="module_id" class="block text-sm font-medium text-slate-700 mb-1.5">Module / Cours</label>
                <select name="module_id" id="module_id" required
                    class="block w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">-- Choisir un cours --</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
                            {{ $module->name }} ({{ $module->group?->name ?? 'Sans groupe' }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full sm:w-48">
                <label for="date" class="block text-sm font-medium text-slate-700 mb-1.5">Date de la Séance</label>
                <input type="date" name="date" id="date" value="{{ $date }}"
                    class="block w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold transition-colors cursor-pointer w-full sm:w-auto">
                Charger la Feuille
            </button>
        </form>
    </div>

    @if($selectedModule)
        <!-- Attendance Sheet Form -->
        <form action="{{ route('teacher.attendance.store') }}" method="POST" class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            @csrf
            <input type="hidden" name="module_id" value="{{ $selectedModule->id }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h4 class="text-base font-bold text-slate-900">Feuille de présence du {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h4>
                    <p class="text-xs text-slate-500">Sélectionnez les étudiants ABSENTS et cliquez sur "Enregistrer la feuille".</p>
                </div>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-colors cursor-pointer">
                    Enregistrer la feuille
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="px-6 py-4 w-20 text-center">Absent ?</th>
                            <th class="px-6 py-4">Nom de l'Étudiant</th>
                            <th class="px-6 py-4">Numéro Étudiant</th>
                            <th class="px-6 py-4">Statut Précédent</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($students as $student)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" name="absences[]" value="{{ $student->id }}"
                                        {{ $student->is_absent ? 'checked' : '' }}
                                        class="h-4 w-4 bg-slate-100 border-slate-200 text-rose-600 rounded focus:ring-rose-500">
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ $student->user?->name }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs">{{ $student->student_number }}</td>
                                <td class="px-6 py-4">
                                    @if($student->is_absent)
                                        <span class="px-2 py-0.5 text-xs rounded font-medium bg-rose-100 text-rose-800">
                                            Absent ({{ $student->absence_type }})
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs rounded font-medium bg-emerald-100 text-emerald-800">
                                            Présent
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">Aucun étudiant dans ce groupe.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    @endif
</div>
@endsection
