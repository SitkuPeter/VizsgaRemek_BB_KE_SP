@extends('layouts.game')

@section('pageTitle', 'Crash Casino Game')

@section('content')
<body class="min-h-screen dark:bg-neutral-900 bg-neutral-100 flex items-center justify-center">
    <div class="dark:bg-neutral-600 bg-white p-6 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-bold text-center mb-6">Crash Casino Game</h1>

        <!-- User Balance & Current Bet -->
        <div class="mb-4 flex justify-between items-center px-4">
            <span id="user-balance" class="text-black dark:text-white">
                Balance: ${{ number_format(Auth::user()->balance, 2) }}
            </span>
            <span id="current-bet" class="font-semibold text-blue-600 dark:text-blue-400"></span>
        </div>

        <!-- Game Controls -->
        <div class="flex justify-center items-center space-x-4 mb-6">
            <button id="start-game" class="px-6 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition duration-300">
                Start Game
            </button>
            <button id="cash-out" disabled class="px-6 py-2 bg-yellow-500 text-white font-semibold rounded-md hover:bg-yellow-600 transition duration-300">
                Cash Out
            </button>
        </div>

        <!-- Multiplier Display -->
        <div class="mb-6">
            <p class="text-xl font-bold text-center">
                Multiplier: <span id="current-multiplier">1.00x</span>
            </p>
            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-4 mt-2">
                <div id="progress-fill" class="bg-red-500 h-full rounded-full" style="width: 0%;"></div>
            </div>
        </div>

        <!-- Betting Area -->
        @include('layouts.betingarea')

        <!-- Game History & Results -->
        <div class="mb-6">
            <h3 class="text-lg font-bold text-center">Previous Crash Points:</h3>
            <ul id="crash-history" class="mt-2 text-sm text-center space-y-1"></ul>
        </div>
        <p id="game-result" class="text-lg font-bold text-center"></p>

        <!-- Hidden API Token -->
        @if(Auth::check())
            <input type="hidden" id="api-token" value="{{ Auth::user()->createToken('api-token')->plainTextToken }}">
        @endif
    </div>

    @vite('resources/css/crash.css')
    @vite('resources/js/crash.js')
</body>
@endsection
