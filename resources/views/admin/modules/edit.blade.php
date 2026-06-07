@extends('layouts.app')

@section('title', 'Modifier un Module - PFM')
@section('header_title', 'Modifier un Module')

@section('content')
<div class="max-w-2xl bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
    <form action="{{ route('admin.modules.update', $module->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nom du Module</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $module->name) }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-slate-700 mb-1.5">Code</label>
                <input type="text" name="code" id="code" required value="{{ old('code', $module->code) }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="teacher_id" class="block text-sm font-medium text-slate-700 mb-1.5">Enseignant</label>
                <select name="teacher_id" id="teacher_id"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Non assigné</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $module->teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="group_id" class="block text-sm font-medium text-slate-700 mb-1.5">Groupe</label>
                <select name="group_id" id="group_id"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Aucun groupe</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ old('group_id', $module->group_id) == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="credits" class="block text-sm font-medium text-slate-700 mb-1.5">Crédits</label>
                <input type="number" name="credits" id="credits" min="0" value="{{ old('credits', $module->credits) }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Statut</label>
                <select name="status" id="status" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="active" {{ old('status', $module->status) == 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ old('status', $module->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    <option value="archived" {{ old('status', $module->status) == 'archived' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-slate-700 mb-1.5">Niveau</label>
                <select name="level" id="level"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Sélectionner un niveau</option>
                    @foreach($levels as $level)
                        <option value="{{ $level }}" {{ old('level', $module->level) == $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="semester" class="block text-sm font-medium text-slate-700 mb-1.5">Semestre</label>
                <select name="semester" id="semester"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Sélectionner un semestre</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester }}" {{ old('semester', $module->semester) == $semester ? 'selected' : '' }}>
                            {{ $semester }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
            <textarea name="description" id="description" rows="4"
                class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">{{ old('description', $module->description) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.modules.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-colors cursor-pointer">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
