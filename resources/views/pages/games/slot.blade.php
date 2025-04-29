@extends('layouts.game')

@section('pageTitle', 'Slot Machine Casino Game')

@section('content')
    <div class="max-w-3xl mx-auto bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-black dark:text-white">Slot Machine Casino Game</h1>

        <!-- Info Button -->
        <button id="info-button"
            class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition duration-300 mb-4">
            Game Info
        </button>

        <!-- Popup Modal -->
        <div id="info-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden modal">
            <div class="bg-neutral-800 p-6 rounded-lg shadow-lg max-w-lg w-full text-white relative">
                <button id="close-modal"
                    class="absolute top-2 right-2 text-xl text-red-500 hover:text-red-600">&times;</button>
                <h2 class="text-2xl font-bold mb-4">Slot Machine Rules</h2>

                <h3 class="text-xl font-bold mb-2">How to Win:</h3>
                <ul class="list-disc pl-6 mb-4 text-gray-300">
                    <li class="mb-2"><strong>3 Symbols:</strong> Anywhere on the reels <span
                            class="text-sm text-green-400">(non-adjacent)</span></li>
                    <li class="mb-2"><strong>4-5 Symbols:</strong> Must be consecutive <span
                            class="text-sm text-red-400">(left to right)</span></li>
                    <li>Higher matches override lower ones (5 symbols > 4 symbols > 3 symbols)</li>
                </ul>

                <h3 class="text-xl font-bold mb-2">Payout Table:</h3>
                <div class="space-y-4">
                    <!-- Any 3 Symbols -->
                    <div>
                        <h4 class="font-bold mb-1 text-green-400">Any 3 Symbols:</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            @foreach (['🍒' => 5, '🍋' => 10, '🍉' => 15, '⭐' => 20, '💎' => 25] as $symbol => $payout)
                                <div>{{ $symbol }}{{ $symbol }}{{ $symbol }}<span
                                        class="float-right">{{ $payout }}× bet</span></div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Adjacent 4-5 Symbols -->
                    <div>
                        <h4 class="font-bold mb-1 text-red-400">Adjacent 4-5 Symbols:</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            @foreach (['🍒' => [10, 20], '🍋' => [20, 40], '🍉' => [30, 60], '⭐' => [40, 80], '💎' => [50, 100]] as $symbol => [$payout4, $payout5])
                                <div>{{ $symbol }}×4<span class="float-right">{{ $payout4 }}× bet</span></div>
                                <div>{{ $symbol }}×5<span class="float-right">{{ $payout5 }}× bet</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button id="close-modal-bottom"
                    class="px-6 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition duration-300 mt-4">
                    Close
                </button>
            </div>
        </div>

        <!-- User Balance -->
        <span id="user-balance" class="text-black dark:text-white">Balance:
            ${{ number_format(Auth::user()->balance, 2) }}</span>

        <!-- Reels Display -->
        <div class="flex justify-center items-center space-x-4 mb-6">
            @for ($i = 1; $i <= 5; $i++)
                <div id="reel{{ $i }}"
                    class="w-16 h-16 flex items-center justify-center bg-neutral-400 dark:bg-neutral-700 rounded-lg text-3xl font-bold text-white">
                    ?
                </div>
            @endfor
        </div>

        <!-- Betting Section -->
        @include('layouts.betingarea')
        <div class="flex justify-center items-center space-x-4 mb-6">
            <button id="spin-reels"
                class="px-6 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition duration-300">
                Spin Reels
            </button>
            <button id="auto-spin"
                class="px-6 py-2 bg-yellow-500 text-white font-semibold rounded-md hover:bg-yellow-600 transition duration-300">
                Auto Spin
            </button>
        </div>

        <!-- Multiplier/Payout Display -->
        <div class="mb-[1.5rem]">
            <p class='text-xl font-bold'>Multiplier:
                <span id='current-multiplier'>1x</span>
            </p>
            <progress id='progress-fill' value='0' max='100'></progress>
        </div>

        <!-- Win History -->
        <h3>Previous Wins</h3>
        <ul id='win-history' class='list-disc pl-[1rem]'></ul>

        <!-- Game Result -->
        <p id='game-result' class='text-lg font-bold text-center mt-[1rem]'></p>

        @if (Auth::check())
            <!-- API Token for Authenticated Users -->
            <input type='hidden' id='api-token' value="{{ Auth::user()->createToken('api-token')->plainTextToken }}">
        @endif
    </div>

    <!-- Include CSS and JS Files -->
    @vite('resources/css/slot.css')
    @vite('resources/js/slot.js')
@endsection
