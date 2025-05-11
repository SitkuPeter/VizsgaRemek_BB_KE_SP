@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] bg-casino-gradient relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 opacity-10 pointer-events-none z-0 casino-bg-icon"></div>
    <div class="relative z-10 flex flex-col items-center">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-5xl">🐔</span>
            <h1 class="text-3xl md:text-4xl font-extrabold uppercase tracking-widest text-yellow-400 drop-shadow-lg">
                Crossy Road Coming Soon!
            </h1>
        </div>
        <div class="bg-black/40 border border-yellow-400 rounded-lg shadow-lg px-6 py-5 max-w-lg text-center">
            <p class="text-lg font-semibold text-yellow-200">Get ready to dodge cars and win big!</p>
        </div>

        <a href="{{ route('pages.games') }}" class="mt-8">
            <button class="bg-yellow-400/20 border border-yellow-400 rounded-full px-6 py-3 text-yellow-300 font-bold shadow flex items-center gap-2 hover:bg-yellow-400/30 transition">
                🎮 Play Other Games
            </button>
        </a>
    </div>
</div>
@endsection
