<div class="relative mb-6 w-full max-w-3xl mx-auto">
    <flux:heading size="xl" level="1" class="text-center mb-6">{{ __('Create Article') }}</flux:heading>
    <flux:separator variant="subtle" class="mb-6" />

    <form wire:submit="save" class="space-y-6">
        <flux:label for="title">Title</flux:label>
        <flux:input wire:model.defer="title" id="title" wire:model.live="title" placeholder="Enter article title..." class="w-full" />

        <flux:input
            label="Slug"
            wire:model.live.debounce.1000ms="slug"
            :state="$errors->has('slug') ? 'error' : null"
            pattern="[a-z\-]*"
            helper="Only lowercase letters separated by a hyphen (e.g. my-example-article)"
        />

        <flux:textarea label="Content" id="content" wire:model.live="content" placeholder="Enter article content..." rows="10" class="w-full" />

        <div>
            <flux:label for="image">Image (optional)</flux:label>
            <flux:input type="file" id="image" wire:model.live="image" class="w-full" accept="image/*" />
            @if($image && !is_string($image))
                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="mt-2 max-w-xs rounded" />
            @else
                <p class="text-gray-500 text-sm mt-2">No image uploaded.</p>
            @endif
        </div>

        <flux:label>Developers (optional)</flux:label>
        <flux:checkbox.group wire:model.live="developers" class="flex flex-col gap-1">
            @foreach($availableDevelopers as $availableDeveloper)
                <div class="flex items-center gap-2">
                    <flux:checkbox wire:key="{{ $availableDeveloper->id }}" label="{{ $availableDeveloper->name }}" value="{{ $availableDeveloper->id }}" />
                </div>
            @endforeach
            @if($availableDevelopers->isEmpty())
                <p class="text-sm text-gray-500">No developers available</p>
            @endif
        </flux:checkbox.group>

        <div class="flex gap-2 justify-end">
            <flux:button type="button" variant="ghost" wire:navigate href="{{ route('articles') }}">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</div>
