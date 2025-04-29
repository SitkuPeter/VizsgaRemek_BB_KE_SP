@props(['ad' => null])

<div class="flex items-center justify-center min-h-screen bg-neutral-100 dark:bg-neutral-900 py-10">
    <div class="w-full max-w-5xl bg-neutral-200 dark:bg-neutral-800 rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-6 text-neutral-900 dark:text-white">
            {{ $ad ? 'Edit Advertisement' : 'Create Advertisement' }}
        </h1>

        @if ($ad)
            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <p>Created by: {{ $ad->creator?->name ?? 'N/A' }}</p>
                @if ($ad->updated_by)
                    <p>Last updated by: {{ $ad->updater?->name ?? '—' }}</p>
                @endif
            </div>
        @endif

        <form action="{{ $ad ? route('admin.ads.update', $ad) : route('admin.ads.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if ($ad)
                @method('PUT')
            @endif

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $ad->title ?? '') }}"
                    class="mt-1 block w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-300 sm:text-sm"
                    required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description"
                    class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-300 sm:text-sm"
                    required>{{ old('description', $ad->description ?? '') }}</textarea>
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <label for="duration_seconds"
                    class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Duration (seconds)</label>
                <input type="number" name="duration_seconds" id="duration_seconds" min="1"
                    value="{{ old('duration_seconds', $ad->duration_seconds ?? '') }}"
                    class="mt-1 block w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-300 sm:text-sm"
                    required>
            </div>

            <!-- Reward -->
            <div class="mb-4">
                <label for="reward_amount" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Reward
                    ($)</label>
                <input type="number" name="reward_amount" id="reward_amount" step="0.01" min="0"
                    value="{{ old('reward_amount', $ad->reward_amount ?? '') }}"
                    class="mt-1 block w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-300 sm:text-sm"
                    required>
            </div>

            <!-- Media Type -->
            <div class="mb-4">
                <label for="media_type" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Media
                    Type</label>
                <select name="media_type" id="media_type"
                    class="mt-1 block w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-300 sm:text-sm"
                    required>
                    <option value="image" {{ old('media_type', $ad->media_type ?? '') === 'image' ? 'selected' : '' }}>
                        Image</option>
                    <option value="video" {{ old('media_type', $ad->media_type ?? '') === 'video' ? 'selected' : '' }}>
                        Video</option>
                </select>
            </div>

            <!-- Thumbnail Image -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Thumbnail
                    Image</label>
                <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png"
                    class="mt-1 block w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-300 sm:text-sm">
                @if ($ad?->image)
                    <div class="mt-2">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Current Thumbnail:</span>
                        <img src="{{ Storage::url("ads/{$ad->id}/thumbnails/{$ad->image}") }}"
                            alt="{{ $ad->title }}" class="h-auto max-w-xs mt-2 rounded-md shadow">
                    </div>
                @endif
            </div>

            <!-- Main Media File -->
            <div class="mb-4">
                <label for="media_file" class="block text-sm font-medium text-neutral-700 dark:text-gray-300">Main Media
                    File</label>
                <input type="file" name="media_file" id="media_file"
                    class="mt-1 block w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-300 sm:text-sm">
                @if ($ad)
                    @if ($ad->media_type === 'image' && $ad->image_path)
                        <div class="mt-2">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Current Image:</span>
                            <img src="{{ $ad->image_path }}" alt="Current Image"
                                class="h-auto max-w-xs mt-2 rounded-md shadow">
                        </div>
                    @elseif ($ad->media_type === 'video' && $ad->video_path)
                        <div class="mt-2">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Current Video:</span>
                            <video controls class="max-w-xs mt-2 rounded-md shadow">
                                <source src="{{ $ad->video_path }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.ads.index') }}"
                    class="bg-neutral-400 hover:bg-neutral-500 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                    Back
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                    {{ $ad ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</div>
