<div class="relative mb-6 w-full">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-4">
        <flux:heading size="xl" level="1" class="flex-shrink-0 text-center w-full sm:w-auto">{{ __('Skills') }}</flux:heading>
        <div class="flex items-center justify-start gap-2 w-full sm:flex-1">
            <flux:input class="w-full sm:flex-1" wire:model.live="searchQuery" placeholder="Skill name..." />
            <flux:modal.trigger name="create-skill">
                <flux:button class="flex-shrink-0">Add skill</flux:button>
            </flux:modal.trigger>
        </div>
    </div>
    <flux:separator variant="subtle" />

    @session('success')
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        class="absolute top-5 right-5 bg-green-500 text-zinc-500 text-sm p-4 rounded-lg shadow-lg z-50"
        role="alert"
    >
        <p>{{ $value }}</p>
    </div>
    @endsession('success')

    <livewire:create-skill/>
    <livewire:edit-skill/>

    <!-- Skills table -->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3 flex justify-start">
                Name
            </th>
            <th scope="col" class="px-6 py-3">
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($skills as $skill)
            <tr class="border-b">
                <td class="px-6 mb-1">
                    {{ $skill->name }}
                </td>
                <td class="px-6 mb-1 flex items-center justify-start">
                    <div class="flex items-center gap-1">
                        <flux:button size="xs" wire:click="edit({{ $skill->id }})"><flux:icon.pencil-square variant="mini" /></flux:button>
                        <flux:button size="xs" variant="danger" wire:click="delete({{ $skill->id }})"><flux:icon.x-mark variant="mini" /></flux:button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $skills->links('') }}
    </div>

    <flux:modal name="delete-skill" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete skill?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete this skill.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="deleteSkill">Delete skill</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
