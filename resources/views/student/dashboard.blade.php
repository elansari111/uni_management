@extends('layouts.app')

@section('title', 'Student Dashboard - PFM')
@section('header_title', __('Student Space'))

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('General Average') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">
                    {{ $gpa > 0 ? number_format($gpa, 2) . ' / 20' : __('N/A') }}
                </h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Total Absences') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $absencesCount }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Unexcused Absences') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $unexcusedCount }}</h3>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Grades -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">{{ __('Recent Grades') }}</h4>
                <a href="{{ route('student.grades.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">{{ __('Details') }}</a>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($recentGrades as $grade)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ $grade->module?->name }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ __('Final Grade') }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-sm font-bold text-indigo-600">
                                    {{ $grade->final_grade !== null ? number_format($grade->final_grade, 2) : '-' }} / 20
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">{{ __('No grades recorded yet.') }}</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">{{ __('Announcements & News') }}</h4>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($announcements as $ann)
                        <li class="py-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ $ann->title }}
                                    </p>
                                    <p class="text-xs text-slate-500 line-clamp-2 mt-1">
                                        {{ $ann->content }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-2">
                                        {{ __('By') }} {{ $ann->creator?->name ?? 'Administrateur' }} • {{ $ann->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">{{ __('No announcements.') }}</p>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
