@props(['active' => false])

<li class="{{ $active ? 'nav-active' : ' '}} ">
    <a class="nav-link" {{ $attributes }}>
        {{ $slot }}
    </a>
</li>