@extends('layouts.app')

@section('title', 'Réservations de Salles - PFM')
@section('header_title', 'Demandes de Réservations de Salles')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Demandeur</th>
                        <th class="px-6 py-4">Salle</th>
                        <th class="px-6 py-4">Date de Réservation</th>
                        <th class="px-6 py-4">Créneau</th>
                        <th class="px-6 py-4">Motif</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $reservation->user?->name }}</td>
                            <td class="px-6 py-4 font-medium">{{ $reservation->classroom?->name }}</td>
                            <td class="px-6 py-4">{{ $reservation->reservation_date }}</td>
                            <td class="px-6 py-4">{{ $reservation->start_time }} - {{ $reservation->end_time }}</td>
                            <td class="px-6 py-4 max-w-[200px] truncate" title="{{ $reservation->purpose }}">{{ $reservation->purpose }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize
                                    {{ $reservation->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $reservation->status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $reservation->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                ">
                                    {{ $reservation->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($reservation->status === 'pending')
                                    <form action="{{ route('admin.reservations.approve', $reservation->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-semibold cursor-pointer">Accepter</button>
                                    </form>
                                    
                                    <!-- Reject Form Modal Trigger / Inline -->
                                    <form action="{{ route('admin.reservations.reject', $reservation->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Rejeter cette demande ?')">
                                        @csrf
                                        <input type="text" name="rejection_reason" placeholder="Raison..." required
                                            class="px-2 py-1 text-xs border border-slate-200 rounded bg-white focus:outline-none focus:ring-1 focus:ring-rose-500">
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold cursor-pointer">Refuser</button>
                                    </form>
                                @else
                                    <span class="text-slate-400">Aucune action</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">Aucune demande de réservation trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection
