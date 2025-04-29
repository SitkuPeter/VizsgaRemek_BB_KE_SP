@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] bg-casino-gradient relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 opacity-10 pointer-events-none z-0 casino-bg-icon"></div>
    <div class="relative z-10 flex flex-col items-center">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-5xl">🎰</span>
            <h1 class="text-3xl md:text-4xl font-extrabold uppercase tracking-widest text-yellow-400 drop-shadow-lg">
                Shop Coming Soon!
            </h1>
        </div>
        <div class="bg-black/40 border border-yellow-400 rounded-lg shadow-lg px-6 py-5 max-w-lg text-center">
            <p class="text-lg font-semibold text-yellow-200 mb-2">Get ready to spin, win, and shop!</p>
            <p class="text-base text-gray-200">
                Our brand new casino shop is almost here.<br>
                <span class="inline-block mt-2 px-2 py-1 rounded bg-yellow-400/20 text-yellow-300 font-bold">
                    Stay tuned for exclusive items, bonuses, and more.
                </span>
            </p>
        </div>
        <div class="flex gap-4 mt-8">
            <div class="bg-yellow-400/20 border border-yellow-400 rounded-full px-6 py-3 text-yellow-300 font-bold shadow flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m4 4h-1v-4h-1m-6 8h18M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Casino Shop
            </div>
            <div class="bg-yellow-400/20 border border-yellow-400 rounded-full px-6 py-3 text-yellow-300 font-bold shadow flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Exciting Prizes
            </div>
        </div>
    </div>
</div>
@endsection

@vite('resources/css/shop.css')
