@extends('layouts.app')

@section('title', 'Demande de Documents - PFM')
@section('header_title', 'Demandes de Documents Administratifs')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Submit Request -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm h-fit">
        <h4 class="text-base font-bold text-slate-900 mb-6">Demander un Document</h4>
        
        <form action="{{ route('student.requests.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="request_type" class="block text-sm font-medium text-slate-700 mb-1">Type de document</label>
                <select name="request_type" id="request_type" required
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="certificate">Certificat de Scolarité</option>
                    <option value="transcript">Relevé de Notes</option>
                    <option value="attestation">Attestation d'Inscription</option>
                </select>
            </div>

            <div>
                <label for="purpose" class="block text-sm font-medium text-slate-700 mb-1">Motif / Destination</label>
                <textarea name="purpose" id="purpose" required rows="3" placeholder="Dossier de bourse, renouvellement carte d'identité..."
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition-colors cursor-pointer text-sm">
                Envoyer la demande
            </button>
        </form>
    </div>

    <!-- Requests & Downloads List -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Generated Documents Available for Download -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <h4 class="text-base font-bold text-slate-900 mb-4">Mes Documents Prêts au Téléchargement</h4>
            
            <div class="flow-root">
                <ul class="-my-4 divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-bold text-slate-900 uppercase">{{ $doc->document_type }}</p>
                                <p class="text-xs text-slate-500">Généré le {{ \Carbon\Carbon::parse($doc->generated_at)->format('d/m/Y H:i') }}</p>
                            </div>
                            <!-- Download link -->
                            <a href="{{ asset('storage/' . $doc->file_path) }}" download class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition-colors">
                                Télécharger PDF
                            </a>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Aucun document disponible pour le moment.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Request logs -->
        <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100">
                <h4 class="text-base font-bold text-slate-900">Historique de mes demandes</h4>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Motif</th>
                            <th class="px-6 py-4">Date de Demande</th>
                            <th class="px-6 py-4">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($requests as $req)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900 uppercase">{{ $req->type }}</td>
                                <td class="px-6 py-4 max-w-xs truncate" title="{{ $req->description }}">{{ $req->description }}</td>
                                <td class="px-6 py-4 text-xs">{{ $req->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize
                                        {{ $req->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $req->status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' }}
                                        {{ $req->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                    ">
                                        {{ $req->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">Aucune demande enregistrée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
