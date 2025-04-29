<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:bg-zinc-800 dark:text-white transition duration-300">
<head>
    <link rel="icon" type="image/png" href="{{ asset('storage/img/favicon.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('pageTitle', config('app.name', 'Default App Name'))</title>

    <!-- Icon Pack -->
    <script src="https://kit.fontawesome.com/74fbf94c8e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-zinc-800 transition duration-300">
    <div id="app">
        <!-- Main Content -->
        <main class="container mx-auto py-8 ">
            @yield('content')
            
        </main>
        
    </div>
</body>
</html>