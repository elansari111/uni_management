@extends('layouts.app')

@section('title', 'Réservations Salles - PFM')
@section('header_title', 'Réservations de Salles')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Request form -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm h-fit">
        <h4 class="text-base font-bold text-slate-900 mb-6">Réserver une Salle</h4>
        
        <form action="{{ route('teacher.reservations.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="classroom_id" class="block text-sm font-medium text-slate-700 mb-1">Salle</label>
                <select name="classroom_id" id="classroom_id" required
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Sélectionner une salle</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }} ({{ $classroom->building }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="reservation_date" class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                <input type="date" name="reservation_date" id="reservation_date" required min="{{ date('Y-m-d') }}"
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
                <label for="purpose" class="block text-sm font-medium text-slate-700 mb-1">Motif de la réservation</label>
                <textarea name="purpose" id="purpose" required rows="3" placeholder="Rattrapage de cours, examen blanc, réunion..."
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition-colors cursor-pointer text-sm">
                Soumettre la demande
            </button>
        </form>
    </div>

    <!-- Reservations List -->
    <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h4 class="text-base font-bold text-slate-900">Historique de mes demandes</h4>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Salle</th>
                        <th class="px-6 py-4">Date & Heures</th>
                        <th class="px-6 py-4">Motif</th>
                        <th class="px-6 py-4">Statut / Raison</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($reservations as $res)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">Salle {{ $res->classroom?->name }}</td>
                            <td class="px-6 py-4">
                                <span class="block">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y') }}</span>
                                <span class="text-xs text-slate-500">{{ $res->start_time }} - {{ $res->end_time }}</span>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate" title="{{ $res->purpose }}">{{ $res->purpose }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize block w-fit
                                    {{ $res->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $res->status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $res->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                ">
                                    {{ $res->status }}
                                </span>
                                @if($res->status === 'rejected' && $res->rejection_reason)
                                    <span class="text-xs text-rose-500 block mt-1">Raison: {{ $res->rejection_reason }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Aucune demande de réservation enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
