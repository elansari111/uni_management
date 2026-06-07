@extends('layouts.app')

@section('title', 'Planifier un Cours - PFM')
@section('header_title', 'Planifier un Cours')

@section('content')
<div class="max-w-2xl bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
    
    @if($errors->has('conflict'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-2xl">
            <span class="font-bold">Conflit détecté :</span> {{ $errors->first('conflict') }}
        </div>
    @endif

    <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            
            <div>
                <label for="module_id" class="block text-sm font-medium text-slate-700 mb-1.5">Module / Cours</label>
                <select name="module_id" id="module_id" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Choisir un module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                            {{ $module->name }} ({{ $module->group?->name ?? 'Sans groupe' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="classroom_id" class="block text-sm font-medium text-slate-700 mb-1.5">Salle de Classe</label>
                <select name="classroom_id" id="classroom_id" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Choisir une salle</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }} - Capacité: {{ $classroom->capacity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="day_of_week" class="block text-sm font-medium text-slate-700 mb-1.5">Jour de la Semaine</label>
                <select name="day_of_week" id="day_of_week" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">Sélectionner le jour</option>
                    @foreach($days as $day)
                        <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>
                            {{ ucfirst($day) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-slate-700 mb-1.5">Type de cours</label>
                <select name="type" id="type" required
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="lecture" {{ old('type') == 'lecture' ? 'selected' : '' }}>Cours Magistral (CM)</option>
                    <option value="tutorial" {{ old('type') == 'tutorial' ? 'selected' : '' }}>Travaux Dirigés (TD)</option>
                    <option value="practical" {{ old('type') == 'practical' ? 'selected' : '' }}>Travaux Pratiques (TP)</option>
                    <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Examen</option>
                </select>
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-slate-700 mb-1.5">Heure de Début</label>
                <input type="time" name="start_time" id="start_time" required value="{{ old('start_time') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-slate-700 mb-1.5">Heure de Fin</label>
                <input type="time" name="end_time" id="end_time" required value="{{ old('end_time') }}"
                    class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
            </div>

        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.schedules.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-600/10 transition-colors cursor-pointer">
                Enregistrer la planification
            </button>
        </div>
    </form>
</div>
@endsection
