@extends('layouts.app')

@section('title', 'Justificatifs d\'Absences - PFM')
@section('header_title', 'Validation des Justificatifs d\'Absences')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Étudiant</th>
                        <th class="px-6 py-4">Date de l'Absence</th>
                        <th class="px-6 py-4">Raison</th>
                        <th class="px-6 py-4">Document Preuve</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($justifications as $just)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ $just->absence?->student?->user?->name ?? 'Étudiant inconnu' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $just->absence ? \Carbon\Carbon::parse($just->absence->date)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 max-w-[200px] truncate" title="{{ $just->reason }}">{{ $just->reason }}</td>
                            <td class="px-6 py-4 text-indigo-600">
                                @if($just->document_path)
                                    <a href="{{ asset('storage/' . $just->document_path) }}" target="_blank" class="font-medium underline hover:text-indigo-900">
                                        Voir le document
                                    </a>
                                @else
                                    Aucun document
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize
                                    {{ $just->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $just->status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $just->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                ">
                                    {{ $just->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($just->status === 'pending')
                                    <!-- Approve Form -->
                                    <form action="{{ route('admin.absences.validate', $just->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-semibold cursor-pointer">Accepter</button>
                                    </form>

                                    <!-- Reject Form -->
                                    <form action="{{ route('admin.absences.validate', $just->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Rejeter ce justificatif ?')">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <input type="text" name="rejection_reason" placeholder="Raison..." required
                                            class="px-2 py-1 text-xs border border-slate-200 rounded bg-white focus:outline-none focus:ring-1 focus:ring-rose-500">
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold cursor-pointer">Refuser</button>
                                    </form>
                                @else
                                    <span class="text-slate-400">Traitée</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">Aucun justificatif d'absence en attente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $justifications->links() }}
        </div>
    </div>
</div>
@endsection
