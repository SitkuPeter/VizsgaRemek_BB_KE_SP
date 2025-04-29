@extends('layouts.game')

@section('pageTitle', 'Heads or Tails Game')

@section('content')
    <div class="max-w-3xl mx-auto  dark:bg-neutral-600 bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center mb-6 dark:text-white text-black">Heads or Tails Game</h1>

        <!-- User Balance Display -->
        <p id="user-balance" class="text-xl mb-4 text-center dark:text-white text-black">Balance:
            ${{ number_format(Auth::user()->balance, 2) }}</p>

        <!-- Instructions -->
        <p class="text-lg mb-6 text-center dark:text-white text-black">Choose Heads or Tails and see if you win!</p>

        <!-- Buttons for Selection -->
        <div class="flex justify-center space-x-4 mb-6">
            <button id="heads-btn" class="px-6 py-3 bg-blue-500 text-whiterounded-md hover:bg-blue-600 focus:outline-none">
                <i class="fas fa-coins mr-2"></i> Heads
            </button>
            <button id="tails-btn" class="px-6 py-3 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none">
                <i class="fas fa-coins mr-2"></i> Tails
            </button>
        </div>

        <!-- Coin HTML -->
        <div id="coin-container" class="hidden mb-6 mt-6">
            <div id="coin" class="coin">
                <div class="coin-side heads">
                    <div class="letter-circle">H</div>
                </div>
                <div class="coin-side tails">
                    <div class="letter-circle">T</div>
                </div>
            </div>
        </div>

        <!-- Result Display -->
        <div id="result" class="hidden text-2xl font-semibold mt-6 text-center dark:text-white text-black"></div>

        <!-- Reset Button -->
        <button id="reset-btn"
            class="hidden px-6 py-3 bg-green-500 dark:text-white text-black rounded-md hover:bg-green-600 mt-6 focus:outline-none mx-auto block">
            Play Again
        </button>
        @include('layouts.betingarea')
    </div>

    @if(Auth::check())
        <input type="hidden" id="api-token" value="{{ Auth::user()->createToken('api-token')->plainTextToken }}">
    @endif

    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@vite('resources/css/coinflip.css')
@vite('resources/js/coinflip.js')
