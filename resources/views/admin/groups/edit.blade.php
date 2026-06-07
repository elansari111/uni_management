@extends('layouts.app')

@section('title', 'Modifier un Groupe - PFM')
@section('header_title', 'Modifier un Groupe')

@section('content')
<div class="max-w-2xl bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
    <form action="{{ route('admin.groups.update', $group->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nom</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $group->name) }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-slate-700 mb-1.5">Code</label>
                <input type="text" name="code" id="code" required value="{{ old('code', $group->code) }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="level_id" class="block text-sm font-medium text-slate-700 mb-1.5">Niveau</label>
                <select name="level_id" id="level_id"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Aucun niveau</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $group->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }} ({{ $level->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="capacity" class="block text-sm font-medium text-slate-700 mb-1.5">Capacité</label>
                <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $group->capacity) }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
            <textarea name="description" id="description" rows="4"
                class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">{{ old('description', $group->description) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.groups.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-colors cursor-pointer">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
