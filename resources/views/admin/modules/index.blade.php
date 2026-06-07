@extends('layouts.app')

@section('title', 'Gestion des Modules - PFM')
@section('header_title', 'Gestion des Modules')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <a href="{{ route('admin.modules.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-all">
            + Ajouter Module
        </a>
    </div>

    <!-- Modules Table -->
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Code</th>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Enseignant</th>
                        <th class="px-6 py-4">Groupe</th>
                        <th class="px-6 py-4">Crédits</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @foreach($modules as $module)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $module->code }}</td>
                            <td class="px-6 py-4">{{ $module->name }}</td>
                            <td class="px-6 py-4">{{ $module->teacher?->name ?? 'Non assigné' }}</td>
                            <td class="px-6 py-4">{{ $module->group?->name ?? 'Aucun groupe' }}</td>
                            <td class="px-6 py-4">{{ $module->credits }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize 
                                    {{ $module->status === 'active' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $module->status === 'inactive' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $module->status === 'archived' ? 'bg-slate-100 text-slate-800' : '' }}
                                ">
                                    {{ $module->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.modules.edit', $module->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Modifier</a>
                                <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce module ?')">
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
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $modules->links() }}
        </div>
    </div>
</div>
@endsection
