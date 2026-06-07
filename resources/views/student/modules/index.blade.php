@extends('layouts.app')

@section('title', 'Mes Modules - PFM')
@section('header_title', 'Mes Modules')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Module</th>
                        <th class="px-6 py-4">Code</th>
                        <th class="px-6 py-4">Professeur</th>
                        <th class="px-6 py-4 text-right">Espace</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($modules as $module)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $module->name }}</td>
                            <td class="px-6 py-4">{{ $module->code }}</td>
                            <td class="px-6 py-4">{{ $module->teacher?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('student.classroom.show', $module->id) }}" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition-colors">
                                    Ouvrir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Aucun module n'est assigné à votre groupe.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
