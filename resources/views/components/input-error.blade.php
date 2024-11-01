{{-- @props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif --}}
@props(['messages'])

@if ($messages)
    <div>
        @foreach ((array) $messages as $message)
            <p class="text-danger">{{ $message }}</p>
        @endforeach
    </div>
@endif
