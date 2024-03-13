<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Character Encoding and Viewport -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ $title ?? config('app.name') }}</title>

        <!-- Favicon -->
        {{-- <link rel="icon" href="{{ asset('favicon.svg') }}" sizes="any" type="image/svg+xml" />
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" /> --}}

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Fonts (Preloading for Performance) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
