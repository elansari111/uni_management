@extends('layouts.app')

@section('title', 'Mes Notes - PFM')
@section('header_title', 'Mon Relevé de Notes')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Module</th>
                        <th class="px-6 py-4">Enseignant</th>
                        <th class="px-6 py-4 text-center">CC1 (/20)</th>
                        <th class="px-6 py-4 text-center">CC2 (/20)</th>
                        <th class="px-6 py-4 text-center">Examen (/20)</th>
                        <th class="px-6 py-4 text-center">Note Finale (/20)</th>
                        <th class="px-6 py-4">Remarques</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($grades as $grade)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $grade->module?->name }}</td>
                            <td class="px-6 py-4">{{ $grade->module?->teacher?->user?->name ?? 'Enseignant' }}</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $grade->cc1 !== null ? number_format($grade->cc1, 2) : '-' }}</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $grade->cc2 !== null ? number_format($grade->cc2, 2) : '-' }}</td>
                            <td class="px-6 py-4 text-center font-medium">{{ $grade->exam !== null ? number_format($grade->exam, 2) : '-' }}</td>
                            <td class="px-6 py-4 text-center font-bold text-indigo-600">
                                {{ $grade->final_grade !== null ? number_format($grade->final_grade, 2) : '-' }}
                            </td>
                            <td class="px-6 py-4 italic text-slate-500">{{ $grade->remarks ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">Aucune note n'a encore été saisie pour vos modules.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
