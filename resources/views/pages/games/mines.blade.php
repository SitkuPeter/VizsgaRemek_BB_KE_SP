@extends('layouts.game')

@section('pageTitle', 'Mines Game')

@section('content')
    <div
        class="max-w-3xl mx-auto bg-amber-50 dark:bg-yellow-900 rounded-lg shadow-lg p-6 border-2 border-yellow-400 dark:border-yellow-600">
        <h1 class="text-3xl font-bold text-center mb-6 text-yellow-600 dark:text-yellow-300">Mines Game</h1>

        <!-- Game Info Button -->
        <button id="info-button"
            class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-md hover:bg-yellow-600 transition duration-300 mb-4 shadow-md">
            Game Info
        </button>

        <!-- Game Info Modal -->
        <div id="info-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
            <div class="flex items-center justify-center h-full">
                <div
                    class="bg-amber-50 dark:bg-yellow-800 p-6 rounded-lg shadow-lg max-w-md w-full border-2 border-yellow-400 dark:border-yellow-600">
                    <h2 class="text-2xl font-bold mb-4 text-yellow-600 dark:text-yellow-300">How to Play Mines</h2>
                    <ul class="list-disc pl-5 mb-4 text-yellow-800 dark:text-yellow-100">
                        <li class="mb-2">This game has a fixed difficulty with 7 mines on the grid.</li>
                        <li class="mb-2">Place your bet and click "Start Game".</li>
                        <li class="mb-2">Click on tiles to reveal them. If you find a gem, you continue playing.</li>
                        <li class="mb-2">If you hit a mine, you lose your bet.</li>
                        <li class="mb-2">You can cash out at any time to secure your winnings.</li>
                        <li class="mb-2">The more tiles you reveal without hitting a mine, the higher your multiplier
                            grows.
                        </li>
                        <li class="mb-2">After cashing out, all mine locations will be revealed.</li>
                    </ul>
                    <button id="close-info"
                        class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-md hover:bg-yellow-600 transition duration-300 shadow-md">
                        Close
                    </button>
                </div>
            </div>
        </div>

        

        <!-- Game Grid -->
        <div id="mines-grid" class="grid grid-cols-5 gap-2 mb-6">
            <!-- Grid will be populated by JavaScript -->
        </div>

        <!-- Game Status -->
        <div
            class="mb-6 bg-amber-50 dark:bg-yellow-900 p-4 rounded-lg border border-yellow-300 dark:border-yellow-600 shadow-md">
            <p id="current-multiplier" class="text-xl font-bold text-center text-yellow-600 dark:text-yellow-300">
                Multiplier: 1.00x
            </p>
            <div class="w-full bg-amber-200 dark:bg-yellow-950 rounded-full h-4 mt-2 overflow-hidden shadow-inner">
                <div id="multiplier-progress" class="bg-yellow-500 h-4 rounded-full" style="width: 0%"></div>
            </div>
        </div>

        <!-- Betting Area -->
        @include('layouts.betingarea')

        <!-- Game Controls -->
        <div class="flex justify-center space-x-4 mt-6">
            <button id="start-game"
                class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-md hover:bg-yellow-600 transition duration-300 shadow-md border border-yellow-400">
                Start Game
            </button>
            <button id="cash-out"
                class="px-6 py-3 bg-amber-500 text-white font-semibold rounded-md hover:bg-amber-600 transition duration-300 shadow-md border border-amber-400"
                disabled>
                Cash Out
            </button>
        </div>

        <!-- Game Result -->
        <p id="game-result" class="text-lg font-bold text-center mt-4 text-yellow-600 dark:text-yellow-300"></p>

        <!-- User Balance -->
        <div
            class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white text-2xl mt-6 text-center p-4 rounded-lg shadow-lg border border-yellow-300">
            <span id="user-balance" class="font-bold">
                Current Balance: ${{ number_format(Auth::user()->balance, 2) }}
            </span>
        </div>

        <!-- Game History -->
        <div
            class="mt-6 bg-amber-50 dark:bg-yellow-900 p-4 rounded-lg border border-yellow-300 dark:border-yellow-600 shadow-md">
            <h3 class="text-lg font-bold text-yellow-700 dark:text-yellow-300 mb-2">Recent Games:</h3>
            <ul id="game-history" class="mt-2 text-sm text-yellow-800 dark:text-yellow-200"></ul>
        </div>

        @if (Auth::check())
            <input type="hidden" id="api-token" value="{{ Auth::user()->createToken('api-token')->plainTextToken }}">
        @endif
    </div>

    @vite('resources/css/mines.css')
    @vite('resources/js/mines.js')
@endsection
