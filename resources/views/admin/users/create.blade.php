@extends('layouts.app')

@section('title', 'Ajouter un Utilisateur - PFM')
@section('header_title', 'Ajouter un Utilisateur')

@section('content')
<div class="max-w-2xl bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nom Complet</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse e-mail</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Mot de passe</label>
                <input type="password" name="password" id="password" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Min. 8 caractères">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="role_id" class="block text-sm font-medium text-slate-700 mb-1.5">Rôle</label>
                <select name="role_id" id="role_select" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Sélectionner un rôle</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" data-slug="{{ $role->slug }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Student Group Selection (Hidden by default, shown via JS) -->
            <div id="group_container" class="hidden">
                <label for="group_id" class="block text-sm font-medium text-slate-700 mb-1.5">Groupe (Étudiant)</label>
                <select name="group_id" id="group_id"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Choisir un groupe</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-colors cursor-pointer">
                Enregistrer
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role_select');
        const groupContainer = document.getElementById('group_container');

        function toggleGroupSelect() {
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const roleSlug = selectedOption ? selectedOption.getAttribute('data-slug') : '';
            
            if (roleSlug === 'student') {
                groupContainer.classList.remove('hidden');
            } else {
                groupContainer.classList.add('hidden');
            }
        }

        roleSelect.addEventListener('change', toggleGroupSelect);
        toggleGroupSelect(); // Run on initial load
    });
</script>
@endsection
