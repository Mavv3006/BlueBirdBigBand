<?php
$service = \Illuminate\Support\Facades\App::make(\App\DataTransferObjects\View\InertiaMetaInfoDto::class);
?>

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title inertia>{{ $service->title }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Primary Meta Tags -->
    <meta property="title" content="{{ $service->title }}">
    <meta property="description" content="{{ $service->description }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $service->title }}">
    <meta property="og:url" content="{{ $service->url }}">
    <meta property="og:description" content="{{ $service->description }}">
    @if($service->imageUrl != null)
        <meta property="og:image" content="{{ $service->imageUrl }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:title" content="{{ $service->title }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $service->url }}">
    <meta property="twitter:description" content="{{ $service->description }}">
    @if($service->imageUrl != null)
        <meta property="twitter:image" content="{{ $service->imageUrl }}">
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
