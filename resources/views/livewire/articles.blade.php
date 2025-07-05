<div class="mb-6 w-full">
    <div class="flex justify-between items-center mb-2">
        <flux:heading size="xl" level="1">{{ __('Articles') }}</flux:heading>
        <a href="{{ route('articles.create') }}" target="_blank">
            <flux:button class="mt-4">Add article</flux:button>
        </a>
    </div>
    <flux:separator variant="subtle"" />

    @if (session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-5 right-5 bg-green-500 text-white text-sm p-4 rounded-lg shadow-lg z-50"
            role="alert"
        >
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid gap-4 grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
        @forelse ($articles as $article)
            <div class="rounded-lg shadow p-4 border border-white">
                <div class="flex flex-col gap-4">
                    <div>
                        <div class="flex items-start justify-between mb-2 gap-3">
                            <div class="block mb-2 gap-3">
                                <span class="text-lg font-semibold flex text-gray-800">{{ $article->title }}</span>
                                <flux:badge size="sm" class="h-6 min-w-[28px] flex items-center justify-center">
                                {{ $article->developers->count() }} {{ Str::plural('author', $article->developers->count()) }}
                                </flux:badge>
                            </div>
                            <div class="flex items-start gap-1">
                                <a href="{{ route('articles.edit', $article->id) }}" target="_blank">
                                    <flux:button  size="xs" variant="outline"><flux:icon.pencil-square variant="mini" /></flux:button>
                                </a>
                                <flux:button size="xs" variant="danger" wire:click="delete({{ $article->id }})"><flux:icon.x-mark variant="mini" /></flux:button>
                            </div>
                        </div>
                        <div class="text-gray-500 text-sm flex items-stretch gap-1">
                            <flux:icon.calendar-days variant="mini"/>
                            {{ $article->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-gray-500 text-center">
                <p>{{ __('No articles found.') }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $articles->links() }}
    </div>

    @if ($articleId)
        <flux:modal name="delete-article-{{ $articleId }}" class="min-w-[22rem] bg-white rounded-lg p-6">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg" class="text-xl font-semibold text-gray-800">Delete article?</flux:heading>
                    <flux:text class="mt-2 text-gray-600">
                        <p>You're about to delete this article.</p>
                        <p>This action cannot be reversed.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2 justify-end">
                    <flux:modal.close>
                        <flux:button variant="ghost" class="text-gray-600 hover:bg-gray-100">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button variant="danger" class="bg-red-500 text-white hover:bg-red-600" wire:click="deleteArticle">Delete article</flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
