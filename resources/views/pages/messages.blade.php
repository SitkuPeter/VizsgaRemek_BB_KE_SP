    @extends('layouts.app')

    @section('content')
        <div class="max-w-6xl mx-auto px-4 py-8 min-h-screen">
            <h1 class="text-3xl font-bold text-center mb-6 text-gray-800 dark:text-white">Messages</h1>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Friend list sidebar -->
                <div class="w-full md:w-1/3 bg-white dark:bg-neutral-800 rounded-lg shadow p-4 h-fit">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-100">Your Friends</h2>
                    <ul class="space-y-2">
                        @foreach ($friends as $friend)
                            <li>
                                <a href="{{ route('friends.messages', ['with' => $friend->id]) }}"
                                    class="block px-4 py-2 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-700 transition {{ request('with') == $friend->id ? 'bg-yellow-200 dark:bg-yellow-600 font-bold' : '' }}">
                                    {{ $friend->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Message panel -->
                <div class="w-full md:w-2/3 bg-white dark:bg-neutral-800 rounded-lg shadow p-6">
                    @php
                        $chatUser = $withUser;
                    @endphp


                    @if ($chatUser)
                        <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-100">Chat with
                            {{ $chatUser->name }}</h2>

                        <!-- Message history -->
                        <div class="h-64 overflow-y-auto bg-neutral-100 dark:bg-neutral-700 p-4 rounded-lg mb-4">
                            @forelse($messages as $msg)
                                <div class="mb-2 text-sm">
                                    <span
                                        class="font-semibold {{ $msg->sender_id == auth()->id() ? 'text-yellow-600' : 'text-gray-600' }}">
                                        {{ $msg->sender_id == auth()->id() ? 'You' : $chatUser->name }}:
                                    </span>
                                    <span class="text-gray-800 dark:text-white">{{ $msg->message }}</span>
                                    <span class="text-xs text-gray-400 ml-2">{{ $msg->created_at->format('H:i') }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-gray-300">No messages yet.</p>
                            @endforelse
                        </div>

                        <!-- Send message form -->
                        <form method="POST" action="{{ route('friends.messages.send') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $chatUser->id }}">
                            <input type="text" name="content" placeholder="Type your message..."
                                class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-6 py-2 rounded-lg transition">
                                Send
                            </button>
                        </form>
                    @else
                        <p class="text-gray-500 dark:text-gray-300 text-center">Select a friend to start messaging.</p>
                    @endif
                </div>
            </div>
        </div>
    @endsection
