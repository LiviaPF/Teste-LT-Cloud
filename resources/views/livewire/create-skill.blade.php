<div xmlns:flux="http://www.w3.org/1999/html">
    <flux:modal name="create-skill" class="w-full">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add skill name</flux:heading>
            </div>

            <flux:input type="text" label="Name" wire:model="name" placeholder="Enter skill name" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click="save">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
