@props(['name', 'stroke' => 0])

<svg {{ $attributes->merge(['class' => 'inline-block fill-current ']) }} stroke = "currentColor" stroke-width={{ $stroke ?? '0'}}> 

<use xlink:href="{{ asset('Assets/sprite.svg') }} #{{ $name }}"></use>

</svg>
