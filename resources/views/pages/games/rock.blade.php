@extends('layouts.game')

@section('pageTitle', 'Rock Paper Scissors')

@section('content')
<div class="game-container bg-white dark:bg-neutral-600 p-6 rounded-lg shadow-lg text-center max-w-md mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Rock Paper Scissors</h1>
    
    <div class="choices flex justify-center space-x-6 mb-6">
        <button class="choice text-6xl cursor-pointer hover:scale-125 transition-transform duration-300 text-red-500" data-choice="rock">✊</button>
        <button class="choice text-6xl cursor-pointer hover:scale-125 transition-transform duration-300 text-blue-500" data-choice="paper">✋</button>
        <button class="choice text-6xl cursor-pointer hover:scale-125 transition-transform duration-300 text-green-500" data-choice="scissors">✌️</button>
    </div>

    <div class="result text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300" id="result">Make your move!</div>

    <div class="flex justify-center items-center space-x-6 my-4">
        <div class="text-center">
            <p class="text-lg font-semibold text-gray-600 dark:text-gray-400">You</p>
            <div id="player-choice" class="text-5xl p-2">❔</div>
        </div>
        <div class="text-center">
            <p class="text-lg font-semibold text-gray-600 dark:text-gray-400">Computer</p>
            <div id="computer-choice" class="text-5xl p-2">❔</div>
        </div>
    </div>

    <div class="score space-y-2">
        <p class="text-lg text-gray-600 dark:text-gray-400">Player Score: <span class="font-bold text-black dark:text-white" id="player-score">0</span></p>
        <p class="text-lg text-gray-600 dark:text-gray-400">Computer Score: <span class="font-bold text-black dark:text-white" id="computer-score">0</span></p>
    </div>

    @include('layouts.betingarea')

    <div id="user-balance" class="text-white text-2xl mb-6 text-center">
        Current Balance: ${{ number_format(Auth::user()->balance, 2) }}
    </div>

    @if(Auth::check())
        <input type="hidden" id="api-token" value="{{ Auth::user()->createToken('api-token')->plainTextToken }}">
    @endif
</div>

@vite('resources/css/rockpapersissors.css')
@vite('resources/js/rockpaperscissors.js')

@endsection
