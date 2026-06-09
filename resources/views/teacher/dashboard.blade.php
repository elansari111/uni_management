@extends('layouts.app')

@section('title', 'Teacher Dashboard - PFM')
@section('header_title', __('Teacher Space'))

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('My Modules') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $modulesCount }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Recorded Sessions') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $logsCount }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Room Reservations') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $reservationsCount }}</h3>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Lesson Logs -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">{{ __('Recent Lesson Logs') }}</h4>
                <a href="{{ route('teacher.lesson-logs.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">{{ __('View All') }}</a>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($recentLogs as $log)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ $log->title }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ $log->module?->name }} • {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-xs font-medium text-slate-500">
                                    {{ $log->classroom?->name }}
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">{{ __('No logs recorded.') }}</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Recent Reservations -->
        <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-base font-semibold text-slate-900">{{ __('Reservation Requests') }}</h4>
                <a href="{{ route('teacher.reservations.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">{{ __('Manage') }}</a>
            </div>
            
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-slate-100">
                    @forelse($recentReservations as $res)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ __('Room') }} {{ $res->classroom?->name }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ \Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y') }} • {{ $res->start_time }} - {{ $res->end_time }}
                                    </p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                        {{ $res->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $res->status === 'rejected' ? 'bg-rose-100 text-rose-800' : '' }}
                                        {{ $res->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                    ">
                                        {{ __($res->status) }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-6">{{ __('No reservation requested.') }}</p>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
