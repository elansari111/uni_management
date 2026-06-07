@extends('layouts.app')

@section('title', 'Mes Absences - PFM')
@section('header_title', 'Registre de mes Absences')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Justification Form -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm h-fit">
        <h4 class="text-base font-bold text-slate-900 mb-6">Justifier une Absence</h4>
        
        <form action="{{ route('student.absences.justify') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label for="absence_id" class="block text-sm font-medium text-slate-700 mb-1">Sélectionner l'absence</label>
                <select name="absence_id" id="absence_id" required
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">-- Choisir une absence --</option>
                    @foreach($absences as $abs)
                        @if($abs->status !== 'justified')
                            <option value="{{ $abs->id }}">
                                {{ \Carbon\Carbon::parse($abs->date)->format('d/m/Y') }} - {{ $abs->module?->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-slate-700 mb-1">Motif / Explication</label>
                <textarea name="reason" id="reason" required rows="3" placeholder="Raison médicale, urgence familiale..."
                    class="block w-full px-3 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
            </div>

            <div>
                <label for="document" class="block text-sm font-medium text-slate-700 mb-1">Pièce Justificative (PDF, JPG, PNG)</label>
                <input type="file" name="document" id="document" required
                    class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-colors">
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition-colors cursor-pointer text-sm">
                Envoyer le justificatif
            </button>
        </form>
    </div>

    <!-- Absences List -->
    <div class="lg:col-span-2 bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h4 class="text-base font-bold text-slate-900">Liste de mes absences</h4>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Module / Cours</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($absences as $abs)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ \Carbon\Carbon::parse($abs->date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $abs->module?->name }}</td>
                            <td class="px-6 py-4 capitalize">{{ $abs->type }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize
                                    {{ $abs->status === 'justified' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $abs->status === 'unjustified' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $abs->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                ">
                                    {{ $abs->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Parfait ! Vous n'avez aucune absence enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
