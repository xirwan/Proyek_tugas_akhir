@props(['active' => false, 'items' => []])

<li {{ $attributes->class([$active ? 'nav-active' : '', !empty($items) ? 'nav-parent' : '']) }}>
    {{-- Tampilkan ikon hanya di level utama --}}
    @if ($attributes->has('icon'))
        <a class="nav-link" {{ $attributes }}>
            <i class="{{ $attributes->get('icon') }}" aria-hidden="true"></i>
            <span>{{ $slot }}</span>
        </a>
    @else
        <a class="nav-link" {{ $attributes }}>
            {{ $slot }}
        </a>
    @endif

    @if (!empty($items))
        <ul class="nav nav-children">
            @foreach ($items as $item)
                <li class="{{ !empty($item['items']) ? 'nav-parent' : '' }}">
                    @if (!empty($item['items']))
                        {{-- Rekursif panggil komponen untuk sub-items --}}
                        <x-side-link1 
                            :active="$item['active'] ?? false" 
                            :items="$item['items']">
                            {{ $item['label'] }}
                        </x-side-link1>
                    @else
                        {{-- Sub-item tanpa ikon --}}
                        <a class="nav-link" href="{{ $item['url'] }}">
                            {{ $item['label'] }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</li>
