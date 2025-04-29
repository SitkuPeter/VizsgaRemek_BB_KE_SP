@extends('layouts.game')

@section('content')
<body class="min-h-screen dark:bg-neutral-900 bg-neutral-100 flex items-center justify-center">
    <div class="dark:bg-neutral-600 bg-white p-6 rounded-lg shadow-lg text-center">
        <!-- Roulette Wheel -->
        <div id="roulette-container" 
             class="flex items-center justify-center w-24 h-24 text-white text-2xl font-bold rounded-full shadow-lg mx-auto mb-4">
        </div>

        <!-- Betting Section -->
        <div class="flex flex-col items-center mb-4">
            @include('layouts.betingarea')
            <select id="bet-type" class="px-4 py-2 dark:bg-zinc-800 bg-zinc-200 text-black dark:text-white w-48 text-center mb-4">
            </select>
            <button id="spin-button" 
                    class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                Spin
            </button>
        </div>

        <!-- Result Display -->
        <div id="result" class="mt-4 text-lg font-semibold bg-neutral-200 text-black  dark:bg-neutral-800 dark:text-white"></div>

        <!-- Previous Winners Section -->
        <div id="previous-winners" 
             class="mt-6 bg-neutral-200 text-black  dark:bg-neutral-800 dark:text-white p-4 rounded-lg shadow-md">
            <h3 class="dark:text-white text-black font-semibold mb-2">Previous Winners</h3>
            <div id="previous-winners-container" 
                 class="flex space-x-2 overflow-x-auto"></div>
        </div>

        <!-- User Balance -->
        <span id="user-balance" class="text-white mt-4">Balance: ${{ number_format(Auth::user()->balance, 2) }}</span>

        @if(Auth::check())
            <input type="hidden" id="api-token" value="{{ Auth::user()->createToken('api-token')->plainTextToken }}" class="">
        @endif
    </div>
   
    @vite('resources/js/roulette.js')
    @vite('resources/css/roulette.css')
</body>
@endsection
