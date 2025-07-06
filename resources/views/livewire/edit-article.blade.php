<div class="mb-6 w-full" xmlns:flux="http://www.w3.org/1999/html">
    <div class="flex justify-between items-center mb-2">
        <flux:heading size="xl" level="1" class="text-3xl font-bold text-gray-800">{{ __('Articles') }}</flux:heading>
    </div>
    <flux:separator variant="subtle" class="border-gray-200 mb-6" />

    <div class="space-y-6">
        <div>
            <flux:heading size="lg" class="text-xl font-semibold text-gray-800">Edit article</flux:heading>
        </div>

        <div>
            <flux:input type="text" label="Title" wire:model="title" placeholder="Enter article title" class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <flux:input type="text" label="Slug" wire:model="slug" placeholder="Enter article slug" pattern="[a-z0-9\-]*" class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <flux:textarea rows="15" label="Content" wire:model="content" placeholder="Enter article content" class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <flux:label class="block text-sm font-medium text-gray-700">Current Image</flux:label>
            @if ($article->image)
                <img src="data:image/jpeg;base64,{{ $article->image }}" alt="Current article image" class="mt-2 max-w-xs rounded" />
            @else
                <p class="text-gray-500 text-sm mt-2">No image uploaded.</p>
            @endif
        </div>

        <div>
            <flux:input type="file" label="New Image" wire:model="image" class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <flux:label class="block text-sm font-medium text-gray-700">Developers (authors)</flux:label>
            @forelse ($developers as $developer)
                <div class="mt-1 space-y-2">
                    <flux:checkbox
                        wire:model="developers"
                        value="{{ $developer->id }}"
                        label="{{ $developer->name }}"
                        class="form-checkbox h-4 w-4 text-blue-600"
                    />
                </div>
            @empty
                <p class="text-red-500 text-sm mt-2">No developers found. Please add developers to the database.</p>
            @endforelse
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary" wire:click="save">Save</flux:button>
        </div>
    </div>
</div>
