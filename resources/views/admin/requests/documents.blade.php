@extends('layouts.app')

@section('title', 'Demandes de Documents - PFM')
@section('header_title', 'Demandes de Documents Administratifs')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Demandeur</th>
                        <th class="px-6 py-4">Type de Document</th>
                        <th class="px-6 py-4">Motif de la Demande</th>
                        <th class="px-6 py-4">Date de Demande</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($requests as $req)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                @if($req->student)
                                    {{ $req->student->user?->name }}
                                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">Étudiant</span>
                                @elseif($req->teacher)
                                    {{ $req->teacher->user?->name }}
                                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-violet-100 text-violet-800">Professeur</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium uppercase text-indigo-600">{{ str_replace('_', ' ', $req->type) }}</td>
                            <td class="px-6 py-4 max-w-[220px] truncate" title="{{ $req->purpose ?? $req->description }}">{{ $req->purpose ?? $req->description }}</td>
                            <td class="px-6 py-4">{{ $req->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize
                                    {{ $req->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $req->status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $req->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                ">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($req->status === 'pending')
                                    <!-- Approve form -->
                                    <form action="{{ route('admin.requests.validate', $req->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-semibold cursor-pointer">Approuver & Générer</button>
                                    </form>

                                    <!-- Reject form -->
                                    <form action="{{ route('admin.requests.validate', $req->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Rejeter cette demande ?')">
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
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">Aucune demande de document trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
