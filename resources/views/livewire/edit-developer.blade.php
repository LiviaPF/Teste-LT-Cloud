<div xmlns:flux="http://www.w3.org/1999/html">
    <flux:modal name="edit-developer" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update dev</flux:heading>
            </div>

            <flux:input type="text" label="Name" wire:model="name" placeholder="Enter developer name" />
            <flux:input type="email" label="E-mail" wire:model="email" placeholder="Enter e-mail" />
            <flux:radio.group wire:model="seniority" label="Seniority level">
                <flux:radio value="junior" label="Junior" checked />
                <flux:radio value="mid" label="Mid" />
                <flux:radio value="senior" label="Senior" />
            </flux:radio.group>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click="update">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
