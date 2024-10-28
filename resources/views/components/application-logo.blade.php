@props([
    'path' => 'assets/images/logo.png',
    'public_path' => 'assets/images/logo.png',
])

<img {{ $attributes }} src="{{ $attributes->has('public') ? public_path($public_path) : asset($path) }}"
    alt="{{ config('app.name') }}" />
