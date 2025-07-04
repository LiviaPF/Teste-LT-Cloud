<div>
    <h1 class="text-2xl font-bold mb-4">{{ __('Skills') }}</h1>

    {{-- Skills table --}}
    <table class="table-auto w-full bg-slate-800 mt-5 shadow-md rounded-md">
        <thead class="bg-slate-900">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">Name</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-300">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($skills as $skill)
                <tr class="border-b border-gray-700 hover:bg-gray-800">
                    <td class="px-4 py-2 text-sm text-gray-300">{{ $skill->name }}</td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <flux:button size="xs" variant="outline" wire:click="edit({{ $skill->id }})"><flux:icon.pencil-square variant="mini" /></flux:button>
                        <flux:button size="xs" variant="danger" wire:click="delete({{ $skill->id }})"><flux:icon.x-mark variant="mini" /></flux:button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 text-sm text-gray-300 text-center">No skills found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $skills->links('') }}
    </div>
</div>
