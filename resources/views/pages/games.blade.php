@extends('layouts.app')

@section('content')
    <!-- Games Section -->
    <section class="py-8 sm:py-12 md:py-16">
        <div class="max-w-6xl mx-auto text-center px-4 sm:px-6">
            <h3 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">Casino Games</h3>
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach (['Slot', 'Roulette', 'Blackjack', 'Coinflip', 'Crash', 'Mines', 'Crossy-Road', 'Rock-Paper-Scissors'] as $game)
                    <div
                        class="bg-white dark:bg-neutral-600 p-3 sm:p-4 rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                        <div class="relative overflow-hidden rounded-md aspect-video">
                            <img src="{{ asset('storage/img/' . strtolower($game) . '.jpg') }}" alt="{{ $game }}"
                                class="w-full h-full object-cover rounded-md transition-transform duration-500 hover:scale-110">
                        </div>
                        <h4 class="text-base sm:text-lg font-semibold mt-3 sm:mt-4">{{ $game }}</h4>
                        <a href="{{ in_array(strtolower($game), ['blackjack', 'roulette', 'crash', 'coinflip', 'slot', 'rock-paper-scissors', 'mines']) ? route(strtolower($game)) : '#' }}"
                            class="block mt-2 sm:mt-3" target="_blank">
                            <button
                                    class="w-full inline-flex justify-center items-center px-3 py-2 sm:px-4 sm:py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <span class="mr-1">Play</span>

                            </button>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
