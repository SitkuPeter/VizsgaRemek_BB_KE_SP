@extends('layouts.app')

@section('pageTitle', 'Leaderboard - ' . config('app.name'))

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Leaderboard</h1>
        <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Top players ranked by balance</p>
    </div>

    <div class="bg-white dark:bg-neutral-700 shadow-lg rounded-lg overflow-hidden">
        <!-- Leaderboard Header -->
        <div class="bg-gray-100 dark:bg-neutral-800 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
            <div class="grid grid-cols-12 gap-4 font-semibold text-gray-700 dark:text-gray-200">
                <div class="col-span-1 text-center">#</div>
                <div class="col-span-7 md:col-span-5">Player</div>
                <div class="col-span-4 md:col-span-3 text-right">Balance</div>
                <div class="hidden md:block md:col-span-3 text-right">Last Active</div>
            </div>
        </div>

        <!-- Leaderboard Body -->
        <div class="divide-y divide-gray-200 dark:divide-gray-600">
            @forelse($users as $index => $user)
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-neutral-600 transition duration-150">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <!-- Rank -->
                        <div class="col-span-1 text-center">
                            @if($index === 0)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-500 text-black font-bold">
                                    1
                                </span>
                            @elseif($index === 1)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-black font-bold">
                                    2
                                </span>
                            @elseif($index === 2)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-700 text-white font-bold">
                                    3
                                </span>
                            @else
                                <span class="text-gray-500 dark:text-gray-400 font-medium">
                                    {{ $loop->iteration }}
                                </span>
                            @endif
                        </div>

                        <!-- Player Name -->
                        <div class="col-span-7 md:col-span-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-700 dark:text-gray-300 font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </div>
                                    @if($user->is_admin)
                                        <div class="text-xs text-red-500 dark:text-red-400">
                                            Admin
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Balance -->
                        <div class="col-span-4 md:col-span-3 text-right">
                            <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                                ${{ number_format($user->balance, 2) }}
                            </div>
                        </div>

                        <!-- Last Active -->
                        <div class="hidden md:block md:col-span-3 text-right">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                    No users found.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
