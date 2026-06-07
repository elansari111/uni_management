@extends('layouts.app')

@section('title', 'Gestion des Groupes - PFM')
@section('header_title', 'Gestion des Groupes')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <a href="{{ route('admin.groups.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-all">
            + Ajouter Groupe
        </a>
    </div>

    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Code</th>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Niveau</th>
                        <th class="px-6 py-4">Capacité</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @foreach($groups as $group)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $group->code }}</td>
                            <td class="px-6 py-4">{{ $group->name }}</td>
                            <td class="px-6 py-4">{{ $group->level?->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $group->capacity }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.groups.edit', $group->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Modifier</a>
                                <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-900 font-medium cursor-pointer">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $groups->links() }}
        </div>
    </div>
</div>
@endsection
