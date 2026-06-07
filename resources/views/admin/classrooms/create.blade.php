@extends('layouts.app')

@section('title', 'Ajouter une Salle - PFM')
@section('header_title', 'Ajouter une Salle')

@section('content')
<div class="max-w-2xl bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
    <form action="{{ route('admin.classrooms.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nom</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-slate-700 mb-1.5">Code</label>
                <input type="text" name="code" id="code" required value="{{ old('code') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="building" class="block text-sm font-medium text-slate-700 mb-1.5">Bâtiment</label>
                <input type="text" name="building" id="building" value="{{ old('building') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="floor" class="block text-sm font-medium text-slate-700 mb-1.5">Étage</label>
                <input type="text" name="floor" id="floor" value="{{ old('floor') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="capacity" class="block text-sm font-medium text-slate-700 mb-1.5">Capacité</label>
                <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', 30) }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Statut</label>
                <select name="status" id="status" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status', 'available') === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="equipment" class="block text-sm font-medium text-slate-700 mb-1.5">Équipements (séparés par des virgules)</label>
            <input type="text" name="equipment" id="equipment" value="{{ old('equipment') }}"
                class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                placeholder="projector, computer, whiteboard">
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.classrooms.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-colors cursor-pointer">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
