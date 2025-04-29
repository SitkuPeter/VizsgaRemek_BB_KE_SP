@extends('layouts.app')

@section('title', 'Welcome to Spin It Clean Casino')

@section('content')
    <link rel="stylesheet" href="">

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[500px] flex items-center justify-center text-neutral-900 "
        style="background-image: url('{{ asset('storage/img/casino-bg.png') }}');">
        <div class="text-center bg-white dark:bg-opacity-30 p-8 rounded-lg">
            <h2 class="text-4xl md:text-6xl font-bold">Welcome to Spin It Clean Casino</h2>
            <p class="mt-4 text-lg">Experience world-class games and win big prizes in the most sophisticated online casino.
            </p>
            <button onclick="window.location.href='/register'"
                class="mt-6 px-6 py-3 bg-yellow-600 hover:bg-yellow-700 dark:bg-yellow-400 dark:hover:bg-yellow-500 text-white dark:text-black font-semibold rounded-md shadow-lg">
                Join Now
            </button>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white">
        <div class="max-w-6xl mx-auto text-center">
            <h3 class="text-3xl font-bold mb-8">Why Choose Us?</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-neutral-200 dark:bg-neutral-700 p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-trophy text-4xl text-yellow-500 dark:text-yellow-400"></i>
                    <h4 class="text-xl font-semibold mt-4">Exclusive Games</h4>
                    <p class="mt-2 text-gray-700 dark:text-gray-300">Play a variety of games, including blackjack, slots, and
                        live dealer experiences.</p>
                </div>
                <div class="bg-neutral-200 dark:bg-neutral-700 p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-lock text-4xl text-blue-500 dark:text-blue-400"></i>
                    <h4 class="text-xl font-semibold mt-4">Secure Platform</h4>
                    <p class="mt-2 text-gray-700 dark:text-gray-300">Your data and transactions are protected with top-notch
                        encryption.</p>
                </div>
                <div class="bg-neutral-200 dark:bg-neutral-700 p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-gift text-4xl text-green-500 dark:text-green-400"></i>
                    <h4 class="text-xl font-semibold mt-4">Big Bonuses</h4>
                    <p class="mt-2 text-gray-700 dark:text-gray-300">Enjoy generous welcome bonuses and daily promotions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Games Section -->
    <section class="py-16 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white">
        <div class="max-w-6xl mx-auto text-center">
            <h3 class="text-3xl font-bold mb-8">Popular Games</h3>
            <div class="grid md:grid-cols-4 gap-6">
                @foreach (['Crash', 'Slot', 'Roulette', 'Blackjack'] as $game)
                    <div class="bg-neutral-2    00 dark:bg-neutral-700 p-4 rounded-lg shadow-md">
                        <img src="{{ asset('storage/img/' . strtolower($game) . '.jpg') }}" alt="{{ $game }}"
                            class="w-full h-40 object-cover rounded-md">
                        <h4 class="text-lg font-semibold mt-4">{{ $game }}</h4>
                        <a href="/games/{{ strtolower($game) }}" target="_blank">
                            <button
                                class="mt-4 px-4 py-2 bg-zinc-500 hover:bg-zinc-600 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white font-semibold rounded-md">
                                Play Now
                            </button>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-cover bg-center rounded-lg text-white dark:text-black text-center relative overflow-hidden">
        <!-- Video Background -->
        <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover z-0">
            <source src="storage/img/fallingchips.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Dark Overlay -->
        <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-40 z-10"></div>

        <!-- Content Overlay -->
        <div class="relative z-20 inline-block w-full max-w-lg mx-auto text-center">
            <h3 class="text-5xl font-bold mb-8 text-neutral-100">Ready to Win Big?</h3>
            <button onclick="window.location.href='/register'"
                class="mt-6 px-12 py-5 bg-gray-300 dark:bg-gray-200 text-yellow-600 dark:text-yellow-800 font-semibold rounded-lg shadow-2xl hover:bg-gray-400 hover:text-yellow-800 dark:hover:bg-gray-300 dark:hover:text-yellow-900 transition duration-300 ease-in-out transform hover:scale-105">
                Get Started
            </button>
        </div>
    </section>

    <!-- Footer Section -->
    <section class="py-12 bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center">
                <div class="prose prose-sm prose-invert mx-auto mb-8 text-gray-600 dark:text-gray-300">
                    <p>A Spin It Clean Casino egy vizsgaremek projekt, amely kizárólag oktatási célokat szolgál, és nem
                        haszonszerzési céllal készült. Az oldal nem valós pénzes szerencsejátékra készült, és semmilyen
                        módon nem kapcsolódik valódi pénzügyi tranzakciókhoz vagy nyereményekhez. Minden játék és tartalom
                        szimulációs célokat szolgál, és nem minősül hivatalos szerencsejáték-platformnak.</p>

                    <p>A weboldal teljes tartalma, beleértve a szövegeket, grafikákat és egyéb anyagokat, szerzői jogi
                        védelem alatt áll. Az oldal bármely részének másolása, terjesztése vagy módosítása kizárólag a
                        készítő írásos engedélyével lehetséges.</p>

                    <p>A Spin It Clean Casino nem vállal felelősséget semmilyen, az oldal használatából eredő közvetlen vagy
                        közvetett kárért. Az oldal használata teljes mértékben saját felelősségre történik.</p>
                </div>
                <p class="text-sm">&copy; Spin It Clean Casino {{ date('Y') }} – Minden jog fenntartva.</p>
            </div>
        </div>
    </section>
    
@endsection
