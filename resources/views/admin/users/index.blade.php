@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs - PFM')
@section('header_title', 'Gestion des Utilisateurs')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <!-- Search and filters -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher nom ou e-mail..." 
                class="px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            
            <select name="role" class="px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                <option value="">Tous les rôles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->slug }}" {{ request('role') == $role->slug ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-semibold transition-colors">
                Filtrer
            </button>
        </form>

        <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-all">
            + Ajouter Utilisateur
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase border-b border-slate-100">
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">E-mail</th>
                        <th class="px-6 py-4">Téléphone</th>
                        <th class="px-6 py-4">Rôle</th>
                        <th class="px-6 py-4">Classe / Spécialité</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize 
                                    {{ $user->role?->slug === 'admin' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $user->role?->slug === 'teacher' ? 'bg-violet-100 text-violet-800' : '' }}
                                    {{ $user->role?->slug === 'student' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                ">
                                    {{ $user->role?->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->student)
                                    {{ $user->student->group?->name ?? 'Aucun groupe' }}
                                @elseif($user->teacher)
                                    {{ $user->teacher->specialization ?? 'Général' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Modifier</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
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
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
