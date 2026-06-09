@extends('layouts.app')

@section('title', 'Admin Dashboard - PFM')
@section('header_title', __('Admin Space'))

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Stat card -->
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Global Users') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['users'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Enrolled Students') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['students'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Active Teachers') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['teachers'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Programmed Modules') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['modules'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-cyan-50 text-cyan-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Classrooms') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['classrooms'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Pending Requests') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">
                    {{ $stats['pending_reservations'] + $stats['pending_requests'] + $stats['pending_absences'] }}
                </h3>
            </div>
        </div>

    </div>
    <!-- Area Chart Section -->
    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-lg font-semibold text-slate-900">{{ __('Activity Overview') }}</h4>
            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-xl bg-purple-500 text-white font-semibold transition-all hover:bg-purple-600 active-period" data-period="7">{{ __('7 days') }}</button>
                <button class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-semibold transition-all hover:bg-slate-200" data-period="30">{{ __('30 days') }}</button>
                <button class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-semibold transition-all hover:bg-slate-200" data-period="90">{{ __('90 days') }}</button>
            </div>
        </div>
        <div style="height: 450px; width: 100%;">
            <canvas id="activityChart"></canvas>
        </div>
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                <p class="text-sm text-indigo-600 font-semibold">{{ __('Sessions') }}</p>
                <p class="text-2xl font-bold text-indigo-900">{{ array_sum($sessions7) }}</p>
            </div>
            <div class="p-4 bg-cyan-50 rounded-2xl border border-cyan-100">
                <p class="text-sm text-cyan-600 font-semibold">{{ __('Absences') }}</p>
                <p class="text-2xl font-bold text-cyan-900">{{ array_sum($absences7) }}</p>
            </div>
            <div class="p-4 bg-pink-50 rounded-2xl border border-pink-100">
                <p class="text-sm text-pink-600 font-semibold">{{ __('Requests') }}</p>
                <p class="text-2xl font-bold text-pink-900">{{ array_sum($requests7) }}</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Students per Group Chart -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
            <h4 class="text-lg font-semibold text-slate-900 mb-6">{{ __('Students per Group') }}</h4>
            <div style="height: 300px;">
                <canvas id="studentsPerGroupChart"></canvas>
            </div>
        </div>

        <!-- Grade Distribution Chart -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
            <h4 class="text-lg font-semibold text-slate-900 mb-6">{{ __('Grade Distribution') }}</h4>
            <div style="height: 300px;">
                <canvas id="gradeChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing charts');
    console.log('Chart available:', typeof window.Chart);
    
    // Activity Area Chart
    const activityCtx = document.getElementById('activityChart');
    let activityChart = null;
    
    const chartData7 = {
        labels: @json($days7),
        sessions: @json($sessions7),
        absences: @json($absences7),
        requests: @json($requests7)
    };
    
    function createActivityChart(data) {
        if (activityChart) {
            activityChart.destroy();
        }
        
        activityChart = new Chart(activityCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: '{{ __('Sessions') }}',
                        data: data.sessions,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: '{{ __('Absences') }}',
                        data: data.absences,
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: '{{ __('Requests') }}',
                        data: data.requests,
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.15)',
                        fill: true,
                        tension: 0.4,
                        borderDash: [5, 5],
                        pointRadius: 5,
                        pointBackgroundColor: '#ec4899',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    createActivityChart(chartData7);
    
    // Students per Group Chart
    const studentsPerGroupCtx = document.getElementById('studentsPerGroupChart');
    if (studentsPerGroupCtx && window.Chart) {
        new Chart(studentsPerGroupCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($groupNames),
                datasets: [{
                    label: '{{ __('Number of students') }}',
                    data: @json($groupStudentCounts),
                    backgroundColor: [
                        '#3b82f6', // Blue
                        '#10b981', // Green
                        '#f59e0b', // Amber
                        '#8b5cf6', // Purple
                        '#ec4899', // Pink
                        '#06b6d4', // Cyan
                        '#84cc16'  // Lime
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Grade Distribution Chart
    const gradeCtx = document.getElementById('gradeChart');
    if (gradeCtx && window.Chart) {
        new Chart(gradeCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['0-5', '6-10', '11-15', '16-20'],
                datasets: [{
                    label: '{{ __('Number of students') }}',
                    data: [
                        {{ $gradeRanges['0-5'] }},
                        {{ $gradeRanges['6-10'] }},
                        {{ $gradeRanges['11-15'] }},
                        {{ $gradeRanges['16-20'] }}
                    ],
                    backgroundColor: [
                        '#ef4444',
                        '#f59e0b',
                        '#10b981',
                        '#3b82f6'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection
