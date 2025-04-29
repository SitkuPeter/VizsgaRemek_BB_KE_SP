@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8 min-h-screen">
        <div class="mb-6">
            <a href="{{ route('forum.index') }}"
                class="text-yellow-500 hover:text-yellow-600 text-sm flex items-center font-medium">
                &larr; Back to forum
            </a>
        </div>
        <div
            class="bg-neutral-200 dark:bg-neutral-700 rounded-xl shadow-md p-6 mb-6 flex gap-4 transition-all duration-300 hover:bg-neutral-300 hover:dark:bg-neutral-800 border border-yellow-200 dark:border-yellow-700">
            <div>
                <div
                    class="w-16 h-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center font-bold text-gray-600 dark:text-gray-200 text-2xl shadow">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</span>
                    @if ($post->is_private)
                        <span class="text-xs bg-yellow-500 text-black px-2 py-0.5 rounded-full shadow">Private</span>
                    @endif
                    <span
                        class="text-gray-500 dark:text-gray-400 text-xs">{{ $post->created_at->format('Y.m.d H:i') }}</span>
                </div>
                <h3 class="text-xl font-bold mt-2 text-gray-900 dark:text-white">{{ $post->title }}</h3>
                <div class="text-gray-700 dark:text-gray-300 mt-3">{{ $post->body }}</div>
                @if (auth()->id() === $post->user_id || (auth()->user()->is_admin ?? false))
                    <form action="{{ route('forum.post.destroy', $post->id) }}" method="POST" class="inline mt-4">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 font-medium"
                            onclick="return confirm('Are you sure you want to delete this post?')">
                            Delete post
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="mb-8">
            <h5 class="font-bold mb-4 text-xl text-gray-900 dark:text-white">Comments ({{ $post->comments->count() }})</h5>
            @forelse($post->comments as $comment)
                <div class="flex gap-3 mb-4">
                    <div>
                        <div
                            class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center font-bold text-gray-600 dark:text-gray-200 text-base shadow">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div
                        class="flex-1 bg-neutral-200 dark:bg-neutral-800 rounded-xl px-4 py-3 transition-all duration-300 hover:bg-neutral-300 hover:dark:bg-neutral-700 border border-yellow-200 dark:border-yellow-700">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span
                                class="font-semibold text-sm text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            @if (auth()->id() === $comment->user_id || (auth()->user()->is_admin ?? false))
                                <form action="{{ route('forum.comment.destroy', $comment->id) }}" method="POST"
                                    class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-red-500 hover:text-red-700 font-medium"
                                        onclick="return confirm('Are you sure you want to delete this comment?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 text-sm mt-1">{{ $comment->body }}</div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-6">
                    <div
                        class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 px-6 py-4 rounded-lg shadow text-lg">
                        No comments yet.
                    </div>
                </div>
            @endforelse
        </div>

        <div
            class="bg-neutral-200 dark:bg-neutral-700 rounded-xl p-5 shadow-md border border-yellow-200 dark:border-yellow-700">
            <form method="POST" action="{{ route('forum.comment.store', $post->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="body" class="block text-sm font-medium text-gray-900 dark:text-white">Add a
                        comment</label>
                    <textarea
                        class="mt-2 block w-full border rounded-lg px-3 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring focus:ring-yellow-300"
                        name="body" id="body" rows="3" required></textarea>
                </div>
                <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-4 py-2 rounded-lg shadow transition">Send
                    Comment</button>
            </form>
        </div>
    </div>
@endsection

@vite('resources/js/post.js')
