<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="dark:bg-zinc-800 dark:text-white transition duration-300">

<head>
    <link rel="icon" type="image/png" href="{{ asset('storage/img/favicon.png') }}">


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle', config('app.name', 'Spin It Clean'))</title>

    <!-- Icon Pack -->
    <script src="https://kit.fontawesome.com/74fbf94c8e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-zinc-800 transition duration-300">
    <div id="app">
        <!-- Navigation Bar -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <main class="container mx-auto py-8">
            @yield('content')
        </main>
    </div>
    @auth
        <!-- Friends Chat Bubble -->
        <a href="{{ route('friends.messages') }}"
            class="fixed bottom-6 right-6 z-50 bg-yellow-400 hover:bg-yellow-500 text-black p-4 rounded-full shadow-lg transition duration-300 flex items-center justify-center"
            title="Friends Chat">
            <i class="fas fa-comments text-xl"></i>
        </a>
    @endauth
</body>

</html>
