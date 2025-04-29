@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8 min-h-screen">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800 dark:text-white">My Friends</h1>

        <!-- Add Friends Button -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('pages.friends') }}"
                class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-8 py-3 rounded-xl shadow-lg transition text-lg w-full max-w-md justify-center">
                <!-- Plus Icon SVG -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add Friends
            </a>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center mb-8 space-x-2">
            <button id="tab-friends"
                class="px-6 py-2 rounded-t-lg font-semibold focus:outline-none transition border-b-2 border-yellow-500 text-yellow-500 dark:text-yellow-400"
                onclick="showTab('friends')">Friends</button>
            <button id="tab-pending"
                class="px-6 py-2 rounded-t-lg font-semibold focus:outline-none transition border-b-2 border-transparent text-gray-500 dark:text-gray-300"
                onclick="showTab('pending')">Pending Requests</button>
        </div>

        <!-- Friends List -->
        <div id="tab-content-friends">
            @if ($friends->isEmpty())
                <div class="flex flex-col items-center justify-center">
                    <div
                        class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 px-6 py-4 rounded-lg shadow text-lg mb-6">
                        You haven't added any friends yet.
                    </div>
                    <a href="{{ route('pages.friends') }}"
                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-6 py-3 rounded-lg shadow transition">
                        Add Friends
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($friends as $friend)
                        <div
                            class="bg-neutral-200 dark:bg-neutral-700 rounded-xl shadow-md p-6 flex flex-col items-center transition-all duration-300 hover:scale-105 hover:bg-neutral-300 hover:dark:bg-neutral-800 border border-yellow-200 dark:border-yellow-700">
                            <!-- Profile Picture or Initials -->
                            <div
                                class="w-20 h-20 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-3xl font-bold text-gray-600 dark:text-gray-200 mb-4 shadow">
                                @if ($friend->profile_photo_url ?? false)
                                    <img src="{{ $friend->profile_photo_url }}" alt="profile pic"
                                        class="w-20 h-20 rounded-full object-cover">
                                @else
                                    {{ strtoupper(substr($friend->name, 0, 1)) }}
                                @endif
                            </div>
                            <!-- Name -->
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $friend->name }}</h2>
                            <!-- Email -->
                            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">{{ $friend->email }}</p>
                            <!-- Balance (if you want to show it) -->
                            @if (isset($friend->balance))
                                <p class="text-green-600 dark:text-green-400 font-bold mt-2">
                                    ${{ number_format($friend->balance, 2) }}</p>
                            @endif
                            <!-- Friend badge -->
                            <span
                                class="mt-4 inline-block bg-yellow-500 text-black text-xs font-semibold px-3 py-1 rounded-full shadow">Friend</span>
                            <!-- Show Info Button -->
                            <a href="{{ route('profile.show', $friend->id) }}"
                                class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-black text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                                Show Info
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Pending Requests Tab -->
        <div id="tab-content-pending" style="display: none;">
            @if ($pendingRequests->isEmpty())
                <div class="flex flex-col items-center justify-center">
                    <div
                        class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 px-6 py-4 rounded-lg shadow text-lg mb-6">
                        No pending requests.
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($pendingRequests as $request)
                        <div
                            class="bg-neutral-100 dark:bg-neutral-800 rounded-xl shadow-md p-6 flex flex-col items-center transition-all duration-300 hover:scale-105 hover:bg-neutral-200 hover:dark:bg-neutral-700 border border-yellow-200 dark:border-yellow-700">
                            <!-- Profile Picture or Initials -->
                            <div
                                class="w-20 h-20 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-3xl font-bold text-gray-600 dark:text-gray-200 mb-4 shadow">
                                @if ($request->sender->profile_photo_url ?? false)
                                    <img src="{{ $request->sender->profile_photo_url }}" alt="profile pic"
                                        class="w-20 h-20 rounded-full object-cover">
                                @else
                                    {{ strtoupper(substr($request->sender->name, 0, 1)) }}
                                @endif
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $request->sender->name }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">{{ $request->sender->email }}</p>
                            @if (isset($request->sender->balance))
                                <p class="text-green-600 dark:text-green-400 font-bold mt-2">
                                    ${{ number_format($request->sender->balance, 2) }}</p>
                            @endif
                            <span
                                class="mt-4 inline-block bg-yellow-500 text-black text-xs font-semibold px-3 py-1 rounded-full shadow">Pending</span>
                            <!-- Accept/Decline Buttons -->
                            <form method="POST" action="{{ route('friend.request.accept', $request->id) }}"
                                class="mt-4 inline-block">
                                @csrf
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-lg font-semibold shadow transition">
                                    Accept
                                </button>
                            </form>
                            <form method="POST" action="{{ route('friend.request.decline', $request->id) }}"
                                class="mt-2 inline-block">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold shadow transition">
                                    Decline
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function showTab(tab) {
            // Tabs
            document.getElementById('tab-friends').classList.remove('border-yellow-500', 'text-yellow-500',
                'dark:text-yellow-400');
            document.getElementById('tab-friends').classList.add('border-transparent', 'text-gray-500',
                'dark:text-gray-300');
            document.getElementById('tab-pending').classList.remove('border-yellow-500', 'text-yellow-500',
                'dark:text-yellow-400');
            document.getElementById('tab-pending').classList.add('border-transparent', 'text-gray-500',
                'dark:text-gray-300');

            // Content
            document.getElementById('tab-content-friends').style.display = 'none';
            document.getElementById('tab-content-pending').style.display = 'none';

            if (tab === 'friends') {
                document.getElementById('tab-friends').classList.add('border-yellow-500', 'text-yellow-500',
                    'dark:text-yellow-400');
                document.getElementById('tab-friends').classList.remove('border-transparent', 'text-gray-500',
                    'dark:text-gray-300');
                document.getElementById('tab-content-friends').style.display = '';
            } else {
                document.getElementById('tab-pending').classList.add('border-yellow-500', 'text-yellow-500',
                    'dark:text-yellow-400');
                document.getElementById('tab-pending').classList.remove('border-transparent', 'text-gray-500',
                    'dark:text-gray-300');
                document.getElementById('tab-content-pending').style.display = '';
            }
        }
     window.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash;

            if (hash === '#pending') {
                showTab('pending');
            } else {
                showTab('friends'); // vagy amit alapértelmezettnek akarsz
            }
        });
    </script>
@endsection
