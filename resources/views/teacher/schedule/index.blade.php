@extends('layouts.app')

@section('title', 'Mon Emploi du Temps - PFM')
@section('header_title', 'Mon Emploi du Temps')

@section('content')
<div class="space-y-6">
    <!-- FullCalendar Container -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
        <div id="calendar"></div>
    </div>
</div>

<!-- FullCalendar Styles -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    // Prepare events
    const events = [
        @foreach($schedulesByDay as $day => $daySchedules)
            @foreach($daySchedules as $item)
                {
                    title: '{{ $item->module?->name }} - {{ $item->classroom?->name ?? "Salle non assignée" }}',
                    daysOfWeek: [{{ array_search($day, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']); }}],
                    startTime: '{{ $item->start_time }}',
                    endTime: '{{ $item->end_time }}',
                    color: getRandomColor()
                },
            @endforeach
        @endforeach
    ];
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'fr',
        firstDay: 1, // Start week on Monday
        slotMinTime: '08:00:00',
        slotMaxTime: '19:00:00',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: events
    });
    
    calendar.render();
    
    function getRandomColor() {
        const colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899'];
        return colors[Math.floor(Math.random() * colors.length)];
    }
});
</script>
@endpush
@endsection
