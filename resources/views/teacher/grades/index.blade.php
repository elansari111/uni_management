@extends('layouts.app')

@section('title', 'Saisie des Notes - PFM')
@section('header_title', 'Saisie des Notes')

@section('content')
<div class="space-y-6">
    <!-- Module Selector -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
        <form method="GET" action="{{ route('teacher.grades.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1">
                <label for="module_id" class="block text-sm font-medium text-slate-700 mb-1.5">Sélectionner le Module</label>
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
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold transition-colors cursor-pointer">
                Charger la liste
            </button>
        </form>
    </div>

    @if($selectedModule)
        <!-- Students list & Grades input -->
        <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100">
                <h4 class="text-base font-bold text-slate-900">Liste des étudiants pour {{ $selectedModule->name }}</h4>
                <p class="text-xs text-slate-500">Formule : Note Finale = ((CC1 + CC2) / 2) × 0.4 + Examen × 0.6</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="px-6 py-4">Nom de l'Étudiant</th>
                            <th class="px-6 py-4">CC1 (/20)</th>
                            <th class="px-6 py-4">CC2 (/20)</th>
                            <th class="px-6 py-4">Examen (/20)</th>
                            <th class="px-6 py-4">Note Finale</th>
                            <th class="px-6 py-4">Remarques</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($students as $student)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ $student->user?->name }}
                                </td>
                                
                                <td colspan="6" class="p-0">
                                    <form action="{{ route('teacher.grades.store') }}" method="POST" class="grid grid-cols-6 items-center w-full px-6 py-3">
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <input type="hidden" name="module_id" value="{{ $selectedModule->id }}">
                                        
                                        <!-- CC1 -->
                                        <div class="pr-4">
                                            <input type="number" name="cc1" step="0.25" min="0" max="20" 
                                                value="{{ old('cc1', $student->grade?->cc1) }}"
                                                class="w-full px-3 py-1.5 border border-slate-200 bg-white rounded-lg text-sm text-center">
                                        </div>

                                        <!-- CC2 -->
                                        <div class="pr-4">
                                            <input type="number" name="cc2" step="0.25" min="0" max="20"
                                                value="{{ old('cc2', $student->grade?->cc2) }}"
                                                class="w-full px-3 py-1.5 border border-slate-200 bg-white rounded-lg text-sm text-center">
                                        </div>

                                        <!-- Exam -->
                                        <div class="pr-4">
                                            <input type="number" name="exam" step="0.25" min="0" max="20"
                                                value="{{ old('exam', $student->grade?->exam) }}"
                                                class="w-full px-3 py-1.5 border border-slate-200 bg-white rounded-lg text-sm text-center">
                                        </div>

                                        <!-- Final grade display -->
                                        <div class="pr-4 font-bold text-slate-900 text-center">
                                            {{ $student->grade?->final_grade !== null ? number_format($student->grade->final_grade, 2) : '-' }}
                                        </div>

                                        <!-- Remarks -->
                                        <div class="pr-4">
                                            <input type="text" name="remarks" value="{{ old('remarks', $student->grade?->remarks) }}"
                                                class="w-full px-3 py-1.5 border border-slate-200 bg-white rounded-lg text-sm"
                                                placeholder="Obs...">
                                        </div>

                                        <!-- Action submit -->
                                        <div class="text-right">
                                            <button type="submit" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold transition-colors cursor-pointer">
                                                Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-400">Aucun étudiant dans ce groupe.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
