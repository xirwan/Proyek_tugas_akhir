{{-- @props(['active' => false])

<li {{ $attributes->class([$active ? 'nav-active' : '', '']) }}>
    <a class="nav-link" {{ $attributes }}>
        {{ $slot }}
    </a>
</li> --}}

@props(['active' => false, 'items' => []])

<li {{ $attributes->class([$active ? 'nav-active' : '', '']) }}>
    <a class="nav-link" {{ $attributes }}>
        {{ $slot }}
    </a>

    @if (!empty($items))
        <ul class="nav nav-children">
            @foreach ($items as $item)
                <li>
                    <a class="nav-link" href="{{ $item['url'] }}">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>