@props(['alt' => config('app.name', 'mb. Design Studio')])

<img {{ $attributes->merge(['class' => 'block']) }} src="{{ \App\Helpers\Helper::viteAsset('img/logo_black.png') }}" alt="{{ $alt }}">
