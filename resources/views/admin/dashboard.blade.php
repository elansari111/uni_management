@extends('layouts.app')

@section('title', 'Admin Dashboard - PFM')
@section('header_title', 'Tableau de Bord Administrateur')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Stat card -->
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <!-- User Icon -->
                <span class="text-2xl font-bold">👥</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Global Users') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['users'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <span class="text-2xl font-bold">👨‍🎓</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Enrolled Students') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['students'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl">
                <span class="text-2xl font-bold">👨‍🏫</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Active Teachers') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['teachers'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                <span class="text-2xl font-bold">📖</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Programmed Modules') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['modules'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-cyan-50 text-cyan-600 rounded-2xl">
                <span class="text-2xl font-bold">🏫</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Classrooms') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['classrooms'] }}</h3>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                <span class="text-2xl font-bold">🔔</span>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">{{ __('Pending Requests') }}</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">
                    {{ $stats['pending_reservations'] + $stats['pending_requests'] + $stats['pending_absences'] }}
                </h3>
            </div>
        </div>

    </div>
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
    
    // Students per Group Chart
    const studentsPerGroupCtx = document.getElementById('studentsPerGroupChart');
    if (studentsPerGroupCtx && window.Chart) {
        new Chart(studentsPerGroupCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($groupNames),
                datasets: [{
                    label: 'Nombre d\'étudiants',
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
                    label: 'Nombre d\'étudiants',
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
