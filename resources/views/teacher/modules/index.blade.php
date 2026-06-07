@extends('layouts.app')

@section('title', 'Mes Modules - PFM')
@section('header_title', 'Mes Modules Assignés')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($modules as $module)
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-2.5 py-1 text-xs font-semibold bg-indigo-50 text-indigo-600 rounded-full uppercase">
                        {{ $module->code }}
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Credits: {{ $module->credits }}</span>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2">{{ $module->name }}</h4>
                <p class="text-sm text-slate-500 mb-4">Groupe: <span class="font-semibold text-slate-700">{{ $module->group?->name ?? 'Aucun' }}</span></p>
                
                @if($module->schedules->isNotEmpty())
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Horaires de cours :</p>
                        <ul class="space-y-1.5 text-xs text-slate-600">
                            @foreach($module->schedules as $sched)
                                <li class="flex justify-between">
                                    <span class="capitalize font-medium">{{ $sched->day_of_week }} :</span>
                                    <span>{{ $sched->start_time }} - {{ $sched->end_time }} ({{ $sched->classroom?->name }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex space-x-2">
                <a href="{{ route('teacher.grades.index', ['module_id' => $module->id]) }}" class="flex-1 text-center py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition-colors">
                    Saisir Notes
                </a>
                <a href="{{ route('teacher.attendance.index', ['module_id' => $module->id]) }}" class="flex-1 text-center py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                    Présences
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center bg-white border border-slate-100 rounded-3xl">
            <p class="text-slate-400">Aucun module ne vous est affecté pour le moment.</p>
        </div>
    @endforelse
</div>
@endsection
