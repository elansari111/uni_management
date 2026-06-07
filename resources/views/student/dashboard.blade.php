@extends('layouts.app')

@section('title', 'Student Dashboard - PFM')
@section('header_title', 'Espace Étudiant')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <span class="text-2xl">📈</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Moyenne Générale</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">
                    {{ $gpa > 0 ? number_format($gpa, 2) . ' / 20' : 'N/A' }}
                </h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                <span class="text-2xl">⚠️</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Absences</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $absencesCount }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                <span class="text-2xl">🚨</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Absences non justifiées</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $unexcusedCount }}</h3>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Grades -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">Dernières Notes Saisies</h4>
                <a href="{{ route('student.grades.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Détails</a>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($recentGrades as $grade)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ $grade->module?->name }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        Note finale calculée
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-sm font-bold text-indigo-600">
                                    {{ $grade->final_grade !== null ? number_format($grade->final_grade, 2) : '-' }} / 20
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Aucune note enregistrée pour le moment.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">Annonces & Actualités</h4>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($announcements as $ann)
                        <li class="py-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ $ann->title }}
                                    </p>
                                    <p class="text-xs text-slate-500 line-clamp-2 mt-1">
                                        {{ $ann->content }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-2">
                                        Par {{ $ann->creator?->name ?? 'Administrateur' }} • {{ $ann->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Aucune annonce.</p>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
