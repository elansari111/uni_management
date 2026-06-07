@extends('layouts.app')

@section('title', 'Admin Dashboard - PFM')
@section('header_title', 'Tableau de Bord Administrateur')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Stat card -->
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <!-- User Icon -->
                <span class="text-2xl font-bold">👥</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Utilisateurs Globaux</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['users'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <span class="text-2xl font-bold">👨‍🎓</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Étudiants inscrits</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['students'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl">
                <span class="text-2xl font-bold">👨‍🏫</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Enseignants actifs</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['teachers'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                <span class="text-2xl font-bold">📖</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Modules programmés</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['modules'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-cyan-50 text-cyan-600 rounded-2xl">
                <span class="text-2xl font-bold">🏫</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Salles de classe</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['classrooms'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                <span class="text-2xl font-bold">🔔</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Demandes en attente</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">
                    {{ $stats['pending_reservations'] + $stats['pending_requests'] + $stats['pending_absences'] }}
                </h3>
            </div>
        </div>

    </div>

    <!-- Quick Links -->
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
        <h4 class="text-lg font-semibold text-slate-900 mb-6">Actions Administratives Rapides</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.create') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl text-center border border-slate-100 transition-all font-medium">
                Créer un Utilisateur
            </a>
            <a href="{{ route('admin.schedules.create') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl text-center border border-slate-100 transition-all font-medium">
                Planifier un Cours
            </a>
            <a href="{{ route('admin.requests.index') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl text-center border border-slate-100 transition-all font-medium text-slate-700">
                Gérer les Attestations
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="p-4 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl text-center border border-slate-100 transition-all font-medium text-slate-700">
                Réservations de Salles
            </a>
        </div>
    </div>
</div>
@endsection
