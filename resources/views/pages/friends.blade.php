@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Add Friends</h1>

        <!-- Keresőmező és szűrés -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <input type="text" id="search" placeholder="Search by name..."
                class="bg-neutral-200 dark:bg-neutral-700 dark:text-white text-black p-2 rounded-lg border border-gray-300 dark:border-gray-600"
                onkeyup="filterUsers()">

            <select name="sort" id="sort"
                class="bg-neutral-200 dark:bg-neutral-700 dark:text-white text-black p-2 rounded-lg">
                <option value="name_asc">Name (A-Z)</option>
                <option value="name_desc">Name (Z-A)</option>
                <option value="balance_asc">Balance (Asc)</option>
                <option value="balance_desc" selected>Balance (Desc)</option>
            </select>
        </div>

        <!-- Felhasználók kártyái -->
        <div id="user-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($users as $user)
                <div class="user-card bg-neutral-200 dark:bg-neutral-700 p-6 rounded-lg shadow-md flex flex-col items-center transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300"
                    data-name="{{ $user->name }}" data-balance="{{ $user->balance }}">

                    <!-- Profilkép vagy kezdőbetű -->
                    <div class="w-20 h-20 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-3xl font-bold text-gray-600 dark:text-gray-200 mb-4 shadow">
                        @if(!empty($user->profile_photo_url))
                            <img src="{{ $user->profile_photo_url }}" alt="profile pic" class="w-20 h-20 rounded-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>

                    <!-- Felhasználó neve -->
                    <h2 class="text-lg font-semibold">{{ $user->name }}</h2>

                    <!-- Egyenleg -->
                    <p class="text-xl font-bold mt-2">{{ $user->balance }} $</p>

                    <!-- Barát hozzáadása gomb -->
                    <form method="POST" action="{{ route('friends.request', $user->id) }}">
                        @csrf
                        <button type="submit"
                            class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                            Add Friend
                        </button>
                    </form>

                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Keresés név alapján
        function filterUsers() {
            const searchValue = document.getElementById("search").value.toLowerCase();
            const userCards = document.querySelectorAll(".user-card");

            userCards.forEach(card => {
                const name = card.dataset.name.toLowerCase();
                if (name.includes(searchValue)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        }

        // Rendezés
        document.getElementById('sort').addEventListener('change', function() {
            const sortValue = this.value;
            const userCards = [...document.querySelectorAll('.user-card')];

            if (sortValue === 'name_asc') {
                userCards.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
            } else if (sortValue === 'name_desc') {
                userCards.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
            } else if (sortValue === 'balance_asc') {
                userCards.sort((a, b) => parseFloat(a.dataset.balance) - parseFloat(b.dataset.balance));
            } else if (sortValue === 'balance_desc') {
                userCards.sort((a, b) => parseFloat(b.dataset.balance) - parseFloat(a.dataset.balance));
            }

            const container = document.getElementById('user-list');
            userCards.forEach(card => container.appendChild(card));
        });

        // Alapértelmezett rendezés betöltéskor
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('sort').dispatchEvent(new Event('change'));
        });
    </script>
@endsection
