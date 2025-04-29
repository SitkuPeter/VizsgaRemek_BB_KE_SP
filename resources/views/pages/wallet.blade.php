@extends('layouts.app')

@section('pageTitle', 'Wallet - Watch Ads for Rewards')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold text-center mb-6 text-black dark:text-white">Wallet</h1>

    <!-- Balance Card -->
    <div class="balance-card p-5 mb-5 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold">Current Balance</h2>
        <p id="balance-amount" class="text-4xl font-bold mt-2">$ {{ number_format($balance, 2) }}</p>
    </div>

    <!-- Available Advertisements -->
    <h2 class="text-2xl font-bold mb-4 text-black dark:text-white">Available Ads</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($ads as $ad)
        <div class="ad-card p-4 border rounded-lg shadow-md bg-white dark:bg-gray-800">
            <h3 class="text-xl font-bold mb-2 text-black dark:text-white">{{ $ad->title }}</h3>
            <p class="mb-2 text-gray-600 dark:text-gray-400">{{ $ad->description }}</p>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-400">Duration: {{ $ad->duration_seconds }}s</span>
                <span class="text-green-600 dark:text-green-400">Reward:$ {{ number_format($ad->reward_amount, 2) }}</span>
            </div>
            <button 
                data-ad-id="{{ $ad->id }}" 
                data-duration="{{ $ad->duration_seconds * 1000 }}" 
                data-media-type="{{ $ad->media_type }}"
                class="ad-btn w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            >
                Watch Ad
            </button>
        </div>
        @endforeach
    </div>

    <!-- Ad Modal -->
    <div id="progress-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center">
        <div class="bg-neutral-800 p-6 rounded-lg shadow-lg max-w-2xl w-full text-white relative">
            <!-- Close Button -->
            <button id="close-modal-btn" class="absolute top-2 right-2 text-xl text-red-500 hover:text-red-600">&times;</button>
            
            <!-- Ad Title -->
            <h2 id="ad-title" class="text-2xl font-bold mb-4">Advertisement</h2>
            
            <!-- Progress bar -->
            <div class="w-full bg-gray-300 rounded-full h-3 mb-4 overflow-hidden">
                <div id="progress-bar" class="bg-blue-500 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>

            <!-- Controls -->
            <div class="flex justify-center mt-2 mb-4">
                <button id="pause-button" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                    Pause
                </button>
            </div>

            <!-- Ad Content -->
            <div class="relative w-full h-96 bg-gray-200 rounded-lg overflow-hidden">
                <video id="ad-video" class="hidden absolute inset-0 w-full h-full object-contain" controls autoplay></video>
                <img id="ad-image" class="hidden absolute inset-0 w-full h-full object-contain" alt="Advertisement">
                <div id="placeholder-box" class="hidden absolute inset-0 flex items-center justify-center text-gray-500 text-xl">
                    ⚠️ Media not available
                </div>
            </div>
        </div>
    </div>

    <!-- Forfeit Option -->
    <div id="forfeit-option" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-md w-full text-center">
            <h3 class="text-xl font-bold mb-4 text-black dark:text-white">Forfeit the reward?</h3>
            <p class="mb-6 text-gray-600 dark:text-gray-300">
                If you close now, you'll lose the opportunity to earn the full reward.
            </p>
            <div class="flex justify-center space-x-4">
                <button id="continue-btn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Continue Watching
                </button>
                <button id="forfeit-btn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Forfeit Reward
                </button>
            </div>
        </div>
    </div>
</div>

@vite(['resources/css/wallet.css', 'resources/js/wallet.js'])
@endsection
