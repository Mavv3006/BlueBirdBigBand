<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | Blue Bird Big Band</title>
    @vite('resources/css/app.css')

</head>
<body>

<div class="wrapper">

    <div class="content">
        <x-layouts.header/>

        {{ $slot }}
    </div>

    <div class="footer">
        <x-layouts.footer/>
    </div>
</div>

</body>
</html>
