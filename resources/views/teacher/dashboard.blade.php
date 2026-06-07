@extends('layouts.app')

@section('title', 'Teacher Dashboard - PFM')
@section('header_title', 'Espace Enseignant')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <span class="text-2xl">📖</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Mes Modules</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $modulesCount }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <span class="text-2xl">📝</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Séances enregistrées</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $logsCount }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl">
                <span class="text-2xl">🏫</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Réservations Salles</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $reservationsCount }}</h3>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Lesson Logs -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">Cahier de Textes Récent</h4>
                <a href="{{ route('teacher.lesson-logs.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Voir tout</a>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($recentLogs as $log)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ $log->title }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ $log->module?->name }} • {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-xs font-medium text-slate-500">
                                    {{ $log->classroom?->name }}
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Aucun log enregistré.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Recent Reservations -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">Demandes de Réservations</h4>
                <a href="{{ route('teacher.reservations.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Gérer</a>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($recentReservations as $res)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        Salle {{ $res->classroom?->name }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ \Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y') }} • {{ $res->start_time }} - {{ $res->end_time }}
                                    </p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                        {{ $res->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $res->status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' }}
                                        {{ $res->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                    ">
                                        {{ $res->status }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Aucune réservation demandée.</p>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
