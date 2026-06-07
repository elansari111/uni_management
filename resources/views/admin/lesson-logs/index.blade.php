@extends('layouts.app')

@section('title', 'Cahiers de Textes - PFM')
@section('header_title', 'Cahiers de Textes')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Horaire</th>
                        <th class="px-6 py-4">Professeur</th>
                        <th class="px-6 py-4">Module</th>
                        <th class="px-6 py-4">Salle</th>
                        <th class="px-6 py-4">Nature</th>
                        <th class="px-6 py-4">Objectif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $log->date?->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">{{ $log->start_time }} - {{ $log->end_time }}</td>
                            <td class="px-6 py-4">{{ $log->teacher?->user?->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $log->module?->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $log->classroom?->name ?? '-' }}</td>
                            <td class="px-6 py-4 capitalize">{{ $log->nature ?? '-' }}</td>
                            <td class="px-6 py-4 max-w-xs truncate" title="{{ $log->objective }}">{{ $log->objective ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">Aucun cahier de textes trouvé.</td>
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
