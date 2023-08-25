<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | Blue Bird Big Band</title>
    @vite('resources/css/app.css')

</head>
<body>

<div class="flex flex-col h-screen">

    <div style="flex: 1 0 auto">
        <livewire:page-header/>

        <div>
            {{ $slot }}
        </div>
    </div>

    <div style="flex-shrink: 0">
        <x-layouts.footer/>
    </div>
</div>

</body>
</html>
