@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 text-gray-200 min-h-screen">
        <!-- Header Section -->
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-extrabold text-black dark:text-white">Admin Dashboard</h1>
                <p class="text-gray-400 mt-2 text-lg">Welcome, {{ auth()->user()->name }}!</p>
            </div>
            <!-- Button to advertisements page -->
            <a href="{{ route('admin.ads.index') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Manage advertisements
            </a>
        </header>

        <!-- Flash messages -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-600 text-white rounded-lg shadow">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-600 text-white rounded-lg shadow">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users Table Section -->
        <section>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-6">All Users</h2>
            <div
                class="overflow-x-auto rounded-lg shadow-lg border dark:border-neutral-700 border-neutral-300 bg-neutral-200 dark:bg-neutral-800">
                <table
                    class="min-w-full divide-y dark:border-neutral-700 border-neutral-300 bg-neutral-200 dark:bg-neutral-800">
                    <!-- Table Header -->
                    <thead class="bg-neutral-200 dark:bg-neutral-800">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Balance
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Role
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-sm font-bold text-neutral-700 dark:text-gray-300 uppercase tracking-wide">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y dark:divide-gray-400 dark:bg-neutral-700 divide-gray-600 bg-neutral-300 ">
                        @foreach ($users as $user)
                            <tr
                                class="dark:hover:bg-neutral-600 hover:bg-neutral-400 transition duration-200 {{ $user->trashed() ? 'opacity-60' : '' }}">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $user->id }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $user->name }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-200 text-neutral-800">
                                    {{ $user->email }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">
                                    ${{ number_format($user->balance, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="
                                        inline-flex items-center px-3 py-1 rounded-full 
                                        {{ $user->is_admin ? 'bg-red-700 text-green-100' : 'bg-green-600 text-blue-100' }}
                                        font-semibold shadow-sm
                                    ">
                                        {{ $user->is_admin ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <!-- Info button -->
                                        <a href="{{ url('/admin/' . $user->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-yellow focus:ring-yellow">
                                            Info
                                        </a>
                                        <!-- Suspend/Restore button -->
                                        <form action="{{ route('admin.suspend', $user->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="{{ $user->trashed() ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-300"
                                                onclick="return confirm('Are you sure you want to {{ $user->trashed() ? 'restore' : 'suspend' }} this user?')">
                                                {{ $user->trashed() ? 'Restore' : 'Suspend' }}
                                            </button>
                                        </form>
                                        <!-- Permanent Delete button (only if already suspended) -->
                                        @if ($user->trashed())
                                            <form action="{{ route('admin.destroy', $user->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-black hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-black"
                                                    onclick="return confirm('Are you sure you want to permanently delete this user?')">
                                                    Delete permanently
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
