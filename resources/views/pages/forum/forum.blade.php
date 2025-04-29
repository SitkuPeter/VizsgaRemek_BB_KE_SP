@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8 min-h-screen">

        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800 dark:text-white">Forum</h1>

        <!-- New Post Button -->
        <div class="flex justify-center mb-6">
            <button id="openNewPostModal" type="button"
                class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-8 py-3 rounded-xl shadow-lg transition text-lg w-full max-w-md justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Post
            </button>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center mb-8 space-x-2">
            <button id="tab-all"
                class="px-6 py-2 rounded-t-lg font-semibold focus:outline-none transition border-b-2 border-yellow-500 text-yellow-500 dark:text-yellow-400"
                onclick="showTab('all')">All Posts</button>
            <button id="tab-friends"
                class="px-6 py-2 rounded-t-lg font-semibold focus:outline-none transition border-b-2 border-transparent text-gray-500 dark:text-gray-300"
                onclick="showTab('friends')">Friends' Posts</button>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tab Content -->
        <div id="tab-content-all">
            <div class="flex justify-center mb-6">
                <form method="GET"
                    class="w-full max-w-md flex flex-col gap-4 bg-neutral-200 dark:bg-neutral-700 p-4 rounded-xl shadow border border-yellow-200 dark:border-yellow-700">
                    {{-- Sort dropdown --}}
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-800 dark:text-gray-200">Sort by:</label>
                        <select name="sort" onchange="this.form.submit()"
                            class="rounded-lg border-gray-300 bg-white dark:bg-neutral-800 dark:text-gray-100 dark:border-gray-600 focus:ring-yellow-500 px-3 py-2 text-sm">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest
                            </option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="most_commented" {{ request('sort') == 'most_commented' ? 'selected' : '' }}>Most
                                Commented</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-6">
                @forelse($posts as $post)
                    <div
                        class="bg-neutral-200 dark:bg-neutral-700 rounded-xl shadow-md p-6 flex gap-4 transition-all duration-300 hover:bg-neutral-300 hover:dark:bg-neutral-800 border border-yellow-200 dark:border-yellow-700">
                        <div>
                            <!-- Avatar Circle with Initial -->
                            <div
                                class="w-16 h-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center font-bold text-gray-600 dark:text-gray-200 text-2xl shadow">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</span>
                                @if ($post->is_private)
                                    <span
                                        class="text-xs bg-yellow-500 text-black px-2 py-0.5 rounded-full shadow">Private</span>
                                @endif
                                <span
                                    class="text-gray-500 dark:text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('forum.post.show', $post->id) }}"
                                class="block mt-2 text-xl font-medium text-gray-900 dark:text-white hover:underline">
                                {{ $post->title }}
                            </a>
                            <div class="text-gray-700 dark:text-gray-300 mt-2">{{ Str::limit($post->body, 120) }}</div>
                            <div class="flex items-center gap-4 mt-4 text-sm">
                                <a href="{{ route('forum.post.show', $post->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                                    View Post
                                </a>
                                <span class="text-gray-600 dark:text-gray-300">{{ $post->comments->count() }}
                                    comments</span>
                                @if (auth()->id() === $post->user_id || (auth()->user()->is_admin ?? false))
                                    <form action="{{ route('forum.post.destroy', $post->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8">
                        <div
                            class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 px-6 py-4 rounded-lg shadow text-lg mb-6">
                            No posts to display.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Friends Tab Content -->
        <div id="tab-content-friends" style="display: none;">
            <div class="grid grid-cols-1 gap-6">
                @php
                    $friendIds = auth()->user()->friends()->pluck('id');
                    $friendPosts = $posts->filter(function ($post) use ($friendIds) {
                        return $friendIds->contains($post->user_id);
                    });
                @endphp

                @forelse($friendPosts as $post)
                    <div
                        class="bg-neutral-200 dark:bg-neutral-700 rounded-xl shadow-md p-6 flex gap-4 transition-all duration-300 hover:bg-neutral-300 hover:dark:bg-neutral-800 border border-yellow-200 dark:border-yellow-700">
                        <div>
                            <!-- Avatar Circle with Initial -->
                            <div
                                class="w-16 h-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center font-bold text-gray-600 dark:text-gray-200 text-2xl shadow">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</span>
                                @if ($post->is_private)
                                    <span
                                        class="text-xs bg-yellow-500 text-black px-2 py-0.5 rounded-full shadow">Private</span>
                                @endif
                                <span
                                    class="text-gray-500 dark:text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('forum.post.show', $post->id) }}"
                                class="block mt-2 text-xl font-medium text-gray-900 dark:text-white hover:underline">
                                {{ $post->title }}
                            </a>
                            <div class="text-gray-700 dark:text-gray-300 mt-2">{{ Str::limit($post->body, 120) }}</div>
                            <div class="flex items-center gap-4 mt-4 text-sm">
                                <a href="{{ route('forum.post.show', $post->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                                    View Post
                                </a>
                                <span class="text-gray-600 dark:text-gray-300">{{ $post->comments->count() }}
                                    comments</span>
                                @if (auth()->id() === $post->user_id || (auth()->user()->is_admin ?? false))
                                    <form action="{{ route('forum.post.destroy', $post->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8">
                        <div
                            class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 px-6 py-4 rounded-lg shadow text-lg mb-6">
                            No posts from friends to display.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $posts->links() }}
            </div>
        </div>

        <!-- Modal Overlay -->
        <div id="newPostModal"
            class="fixed inset-0 bg-black bg-opacity-40 z-40 flex items-center justify-center transition-opacity duration-200 invisible opacity-0 pointer-events-none"
            tabindex="-1" aria-modal="true" role="dialog">
            <!-- Modal Dialog -->
            <div
                class="bg-neutral-200 dark:bg-neutral-700 rounded-xl shadow-xl w-full max-w-md p-6 relative border border-yellow-200 dark:border-yellow-700">
                <button id="closeNewPostModal" type="button"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 text-2xl"
                    aria-label="Close">&times;</button>
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Create New Post</h3>
                <form method="POST" action="{{ route('forum.post.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" name="title" id="title"
                            class="mt-1 block w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-300 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                            required maxlength="255">
                    </div>
                    <div>
                        <label for="body"
                            class="block text-sm font-medium text-gray-900 dark:text-white">Content</label>
                        <textarea name="body" id="body" rows="4"
                            class="mt-1 block w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-300 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                            required></textarea>
                    </div>
                    <label class="flex items-center cursor-pointer select-none">
                        <input
                            class="h-5 w-5 rounded border-gray-300 text-yellow-500 focus:ring-yellow-300 dark:bg-neutral-800 dark:border-gray-600 dark:checked:bg-yellow-500 dark:checked:border-yellow-500 transition"
                            type="checkbox" name="is_private" id="is_private" value="1">
                        <span class="ml-3 text-sm text-gray-900 dark:text-white">Private post</span>
                    </label>
                    <div class="flex gap-2 justify-end pt-2">
                        <button type="button" id="cancelNewPostModal"
                            class="px-4 py-2 rounded-lg bg-gray-300 dark:bg-neutral-600 text-gray-700 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-neutral-500 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-yellow-500 text-black font-semibold shadow hover:bg-yellow-600 transition">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function showTab(tab) {
                // Tabs
                document.getElementById('tab-all').classList.remove('border-yellow-500', 'text-yellow-500',
                    'dark:text-yellow-400');
                document.getElementById('tab-all').classList.add('border-transparent', 'text-gray-500',
                    'dark:text-gray-300');
                document.getElementById('tab-friends').classList.remove('border-yellow-500', 'text-yellow-500',
                    'dark:text-yellow-400');
                document.getElementById('tab-friends').classList.add('border-transparent', 'text-gray-500',
                    'dark:text-gray-300');

                // Content
                document.getElementById('tab-content-all').style.display = 'none';
                document.getElementById('tab-content-friends').style.display = 'none';

                if (tab === 'all') {
                    document.getElementById('tab-all').classList.add('border-yellow-500', 'text-yellow-500',
                        'dark:text-yellow-400');
                    document.getElementById('tab-all').classList.remove('border-transparent', 'text-gray-500',
                        'dark:text-gray-300');
                    document.getElementById('tab-content-all').style.display = '';
                } else {
                    document.getElementById('tab-friends').classList.add('border-yellow-500', 'text-yellow-500',
                        'dark:text-yellow-400');
                    document.getElementById('tab-friends').classList.remove('border-transparent', 'text-gray-500',
                        'dark:text-gray-300');
                    document.getElementById('tab-content-friends').style.display = '';
                }
            }

            // Show the All Posts tab by default
            document.addEventListener('DOMContentLoaded', function() {
                showTab('all');
            });
        </script>
    @endsection

    @vite('resources/js/forum.js')
