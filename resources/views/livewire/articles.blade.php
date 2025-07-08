<div class="relative mb-6 w-full">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-4">
        <flux:heading size="xl" level="1" class="flex-shrink-0 text-center w-full sm:w-auto">{{ __('Articles') }}</flux:heading>
        <div class="flex items-center justify-start gap-2 w-full sm:flex-1">
            <flux:input class="w-full sm:flex-1" wire:model.live="searchQuery" placeholder="Article title..." />
            <flux:button class="flex-shrink-0" wire:navigate href="{{ route('articles.create') }}">Add article</flux:button>
        </div>
    </div>
    <flux:separator variant="subtle" class="mb-4" />

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

    <div class="grid gap-4 grid-cols-1">
        @forelse ($articles as $article)
            <div class="rounded-lg shadow p-4 border border-white max-w-full max-h-screen overflow-hidden">
                <div class="flex flex-col gap-4">
                    <div>
                        <div class="flex items-start justify-between mb-2 gap-3">
                            <div class="block mb-2 gap-3">
                                <span class="text-lg font-semibold flex">{{ $article->title }}</span>
                                <flux:badge size="sm" class="h-6 min-w-[28px] flex items-center justify-center">
                                    {{ $article->developers->count() }} {{ $article->developers->count() === 1 ? 'developer' : 'developers' }}
                                </flux:badge>
                            </div>
                            <div class="flex items-center gap-1">
                                <flux:button size="xs" variant="outline" wire:navigate href="{{ route('articles.edit', ['id' => $article->id]) }}"><flux:icon.pencil-square variant="mini" /></flux:button>
                                <flux:button size="xs" variant="danger" wire:click="delete({{ $article->id }})"><flux:icon.x-mark variant="mini" /></flux:button>
                            </div>
                        </div>
                        <div class="overflow-hidden" style="max-height: 15em; /* Aproximadamente 10 linhas com line-height padrão */">
                            <p class="text-gray-500 break-words">{{ $article->content }}</p>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm flex items-stretch gap-1">
                        <flux:icon.calendar-days variant="mini"/>
                        {{ $article->created_at->format('d/m/Y') }}
                    </div>
                    <div class="flex justify-end">
                        <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" class="hover:underline text-sm">Read full article</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-gray-500">
                <p>{{ __('No articles found.') }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $articles->links('') }}
    </div>

    {{-- Delete articles --}}
    <flux:modal name="delete-article" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete article?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete this article.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="deleteArticle">Delete article</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
