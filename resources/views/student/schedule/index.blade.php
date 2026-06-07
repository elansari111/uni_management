@extends('layouts.app')

@section('title', 'Mon Emploi du Temps - PFM')
@section('header_title', 'Mon Emploi du Temps')

@section('content')
<div class="space-y-6">
    @foreach($days as $key => $label)
        <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h4 class="text-base font-bold text-slate-900">{{ $label }}</h4>
                <span class="text-xs text-slate-500">
                    {{ ($schedulesByDay[$key] ?? collect())->count() }} séance(s)
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                            <th class="px-6 py-4">Horaire</th>
                            <th class="px-6 py-4">Module</th>
                            <th class="px-6 py-4">Professeur</th>
                            <th class="px-6 py-4">Salle</th>
                            <th class="px-6 py-4">Type</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse(($schedulesByDay[$key] ?? collect()) as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $item->start_time }} - {{ $item->end_time }}</td>
                                <td class="px-6 py-4">{{ $item->module?->name }}</td>
                                <td class="px-6 py-4">{{ $item->module?->teacher?->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->classroom?->name ?? '-' }}</td>
                                <td class="px-6 py-4 capitalize">{{ $item->type }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">Aucune séance programmée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
