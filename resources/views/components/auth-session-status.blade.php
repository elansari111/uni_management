@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg']) }}>
        {{ $status }}
    </div>
@endif