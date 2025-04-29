@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 text-gray-200 min-h-screen">
        <!-- Header Section -->
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-extrabold text-black dark:text-white">Advertisement Management</h1>
                <p class="text-gray-400 mt-2 text-lg">Manage your current ads and campaigns.</p>
            </div>
            <!-- Add New Ad button -->
            <a href="{{ route('admin.ads.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Add New Advertisement
            </a>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-600 text-white rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Ads Table Section -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-6">All Advertisements</h2>
            <div
                class="overflow-x-auto rounded-lg shadow-lg border dark:border-neutral-700 border-neutral-300 bg-neutral-200 dark:bg-neutral-800">
                <table
                    class="min-w-full divide-y dark:border-neutral-700 border-neutral-300 bg-neutral-200 dark:bg-neutral-800">
                    <thead class="bg-neutral-200 dark:bg-neutral-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Title</th>
                            <th
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Type</th>
                            <th
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Duration</th>
                            <th
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Reward</th>
                            <th
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Created By</th>
                            <th
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Updated By</th>
                            <th
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-400 dark:bg-neutral-700 divide-gray-600 bg-neutral-300">
                        @foreach ($ads as $ad)
                            <tr class="dark:hover:bg-neutral-600 hover:bg-neutral-400 transition duration-200">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $ad->title }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $ad->media_type === 'video' ? 'Video' : 'Image' }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $ad->duration_seconds }} seconds</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">
                                    {{ number_format($ad->reward_amount, 2) }} $</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $ad->creator?->name ?? 'N/A' }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $ad->updater?->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <!-- Edit -->
                                        <a href="{{ route('admin.ads.edit', $ad) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-yellow">
                                            Edit
                                        </a>
                                        <!-- Delete -->
                                        <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-300"
                                                onclick="return confirm('Are you sure you want to delete this?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 text-gray-800 dark:text-gray-200">
                {{ $ads->links() }}
            </div>
        </section>
    </div>
@endsection
