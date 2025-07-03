<div class="relative mb-6 w-full">
    <div class="flex justify-between items-center mb-2">
        <flux:heading size="xl" level="1">{{ __('Developers') }}</flux:heading>
        <flux:modal.trigger name="create-developer">
            <flux:button class="mt-4">Add developer</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:separator variant="subtle" />
    @session('success')
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        class="fixed bottom-5 right-5 bg-green-500 text-zinc-500 text-sm p-4 rounded-lg shadow-lg z-50"
        role="alert"
    >
        <p>{{ $value }}</p>
    </div>
    @endsession('success')

    <livewire:create-developer/>
    <livewire:edit-developer/>

    <div class="grid gap-4 grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
        @forelse ($developers as $developer)
            <div class="rounded-lg shadow p-4 border border-white">
                <div class="flex flex-col gap-4">
                    <div>
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex mb-2 gap-3">
                                <span class="text-lg font-semibold flex">{{ $developer->name }}</span>
                                <flux:badge size="sm" class="h-6 min-w-[28px] flex items-center justify-center">{{ $developer->articles->count() }}</flux:badge>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:button  size="xs" variant="outline" wire:click="edit({{ $developer->id }})"><flux:icon.pencil-square variant="mini" /></flux:button>
                                <flux:button size="xs" variant="danger" wire:click="delete({{ $developer->id }})"><flux:icon.x-mark variant="mini" /></flux:button>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ $developer->seniority }}</p>
                        <p class="text-gray-500">{{ $developer->email }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @forelse ($developer->skills as $skill)
                            <flux:badge size="sm">{{$skill->name}}</flux:badge>

                        @empty
                            <p class="text-sm text-gray-500">No skills assigned</p>
                        @endforelse
                    </div>
                </div>
            </div>

        @empty
            <div class="col-span-4 text-gray-500">
                <p>{{ __('No developers found.') }}</p>
            </div>
        @endforelse
    </div>

    {{--Pagination--}}
    <div class="mt-4">
        {{ $developers->links('') }}
    </div>

    {{--Delete developers--}}
    <flux:modal name="delete-developer" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete dev?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete this developer.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="deleteDeveloper">Delete developer</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
