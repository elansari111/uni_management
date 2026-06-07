@extends('layouts.app')

@section('title', 'Demandes Administratives - PFM')
@section('header_title', 'Demandes Administratives')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm h-fit">
        <h4 class="text-base font-bold text-slate-900 mb-6">Soumettre une Demande</h4>

        <form action="{{ route('teacher.requests.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="type" class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                <select name="type" id="type" required
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="work_attestation">Attestation de travail</option>
                    <option value="mission_order">Ordre de mission</option>
                </select>
            </div>

            <div id="mission_fields" class="hidden space-y-4">
                <div>
                    <label for="destination" class="block text-sm font-medium text-slate-700 mb-1">Destination</label>
                    <input type="text" name="destination" id="destination"
                        class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1">Début</label>
                        <input type="date" name="start_date" id="start_date"
                            class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1">Fin</label>
                        <input type="date" name="end_date" id="end_date"
                            class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <div>
                    <label for="purpose" class="block text-sm font-medium text-slate-700 mb-1">Motif</label>
                    <textarea name="purpose" id="purpose" rows="3"
                        class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Notes (optionnel)</label>
                <textarea name="description" id="description" rows="3"
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition-colors cursor-pointer text-sm">
                Envoyer
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <h4 class="text-base font-bold text-slate-900 mb-4">Mes Documents Prêts</h4>
            <div class="flow-root">
                <ul class="-my-4 divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-bold text-slate-900 uppercase">{{ str_replace('_', ' ', $doc->type) }}</p>
                                <p class="text-xs text-slate-500">Généré le {{ $doc->generated_at?->format('d/m/Y H:i') }}</p>
                            </div>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" download class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition-colors">
                                Télécharger PDF
                            </a>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">Aucun document disponible.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100">
                <h4 class="text-base font-bold text-slate-900">Historique de mes demandes</h4>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Détails</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Notes Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($requests as $req)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900 uppercase">{{ str_replace('_', ' ', $req->type) }}</td>
                                <td class="px-6 py-4 max-w-xs truncate" title="{{ $req->purpose ?? $req->description }}">
                                    {{ $req->purpose ?? $req->description }}
                                </td>
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
                                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate" title="{{ $req->admin_notes }}">{{ $req->admin_notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">Aucune demande enregistrée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const missionFields = document.getElementById('mission_fields');

        function toggle() {
            if (typeSelect.value === 'mission_order') {
                missionFields.classList.remove('hidden');
            } else {
                missionFields.classList.add('hidden');
            }
        }

        typeSelect.addEventListener('change', toggle);
        toggle();
    });
</script>
@endsection
