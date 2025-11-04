<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMBAHSARI - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<br><br>
    <!-- Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>