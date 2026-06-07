@extends('layouts.app')

@section('title', 'Cahier de Textes - PFM')
@section('header_title', 'Cahier de Textes (Lesson Logs)')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @if(session('success'))
        <div class="col-span-full bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="col-span-full bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="col-span-full bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Log Form -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm h-fit">
        <h4 class="text-base font-bold text-slate-900 mb-6">Enregistrer une Séance</h4>
        
        <form action="{{ route('teacher.lesson-logs.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="module_id" class="block text-sm font-medium text-slate-700 mb-1">Module</label>
                <select name="module_id" id="module_id" required
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Sélectionner</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="classroom_id" class="block text-sm font-medium text-slate-700 mb-1">Salle</label>
                <select name="classroom_id" id="classroom_id" required
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Sélectionner</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                <input type="date" name="date" id="date" required value="{{ date('Y-m-d') }}"
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-slate-700 mb-1">Début</label>
                    <input type="time" name="start_time" id="start_time" required
                        class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-slate-700 mb-1">Fin</label>
                    <input type="time" name="end_time" id="end_time" required
                        class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Titre du cours</label>
                <input type="text" name="title" id="title" required placeholder="ex: Chapitre 1: Introduction"
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="summary" class="block text-sm font-medium text-slate-700 mb-1">Résumé du cours</label>
                <textarea name="summary" id="summary" required rows="4" placeholder="Objectifs abordés, chapitres traités..."
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition-colors cursor-pointer text-sm">
                Enregistrer la séance
            </button>

        </form>
    </div>

    <!-- Logs List -->
    <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h4 class="text-base font-bold text-slate-900">Historique des séances</h4>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Date & Heure</th>
                        <th class="px-6 py-4">Module</th>
                        <th class="px-6 py-4">Salle</th>
                        <th class="px-6 py-4">Titre / Détails</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-900 block">{{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}</span>
                                <span class="text-xs text-slate-500">{{ $log->start_time }} - {{ $log->end_time }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $log->module?->name }}</td>
                            <td class="px-6 py-4">{{ $log->classroom?->name }}</td>
                            <td class="px-6 py-4 max-w-xs">
                                <span class="font-bold block">{{ $log->title }}</span>
                                <span class="text-xs text-slate-500 line-clamp-2">{{ $log->summary }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Aucun log de séance enregistré pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
