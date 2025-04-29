@extends('layouts.game')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <div class="max-w-4xl mx-auto p-6 min-h-screen">
        <!-- Balance Display -->
        <div id="user-balance" class="dark:text-white text-black text-2xl mb-6 text-center">
            Current Balance: ${{ number_format(Auth::user()->balance, 2) }}
        </div>

        <!-- Game Container -->
        <div id="game-container" class="space-y-8">
            <!-- Dealer Section -->
            <div id="dealer-section">
                <h2 class="text-white text-3xl mb-4">Dealer</h2>
                <div id="dealer-cards" class="cards-container flex flex-wrap justify-center gap-4 p-4 dark:bg-gray-600 bg-neutral-300 rounded-lg"></div>
                <p id="dealer-score" class="text-white text-2xl mt-4 text-center">Score: ?</p>
            </div>

            <!-- Action Buttons -->
            <div id="action-buttons" class="flex flex-col md:flex-row gap-4 mb-8">
                <button id="new-game-button" class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    New Game
                </button>
                <div class="flex gap-4">
                    <button id="hit-button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" disabled>
                        Hit
                    </button>
                    <button id="stand-button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" disabled>
                        Stand
                    </button>
                </div>
            </div>

            <!-- Player Section -->
            <div id="player-section">
                <h2 class="text-white text-3xl mb-4">Player</h2>
                <div id="player-cards" class="cards-container flex flex-wrap justify-center gap-4 p-4 dark:bg-gray-600 bg-neutral-300 rounded-lg"></div>
                <p id="player-score" class="text-white text-2xl mt-4 text-center">Score: 0</p>
            </div>
        </div>

        @include('layouts.betingarea')

        <!-- Status Messages -->
        <div id="game-status" class="dark:text-white text-black text-center mt-8 text-lg"></div>
        <div id="game-result" class="dark:text-white text-black text-center mt-4 text-2xl font-bold"></div>
    </div>

    @if(Auth::check())
        <input type="hidden" id="api-token" value="{{ Auth::user()->createToken('api-token')->plainTextToken }}">
    @endif

    @vite('resources/css/BJStyle.css')
    @vite('resources/js/BJScript.js')
@endsection