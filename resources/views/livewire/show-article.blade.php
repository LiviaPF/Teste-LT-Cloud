<div class="relative mb-6 w-full max-w-3xl mx-auto max-h-screen overflow-y-auto">
    <div class="flex items-center justify-between mb-4">
        <flux:button variant="ghost" wire:navigate href="{{ route('articles') }}">Back to Articles</flux:button>
    </div>
    <flux:separator variant="subtle" class="mb-6" />

    @if (session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="absolute top-5 right-5 bg-green-500 text-zinc-500 text-sm p-4 rounded-lg shadow-lg z-50"
            role="alert"
        >
            <p>{{ $value }}</p>
        </div>
    @endif

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <flux:heading size="xl" level="1" class="flex-shrink-0">{{ $article->title }}</flux:heading>
            <flux:text class="text-gray-500 text-sm">
                {{ $article->created_at->format('F j, Y') }}
            </flux:text>
        </div>

        <div class="flex flex-wrap gap-2">
            @forelse ($article->developers as $developer)
                <flux:badge size="sm" class="flex-shrink-0 whitespace-nowrap">{{ $developer->name }}</flux:badge>
            @empty
                <p class="text-sm text-gray-500">No developers assigned</p>
            @endforelse
        </div>

        <div class="w-full">
            @if ($this->imageSrc)
                <img src="{{ $this->imageSrc }}" alt="Imagem do artigo" class="rounded-xl w-full object-cover" />
            @else
                <p class="text-gray-500 text-sm">Nenhuma imagem disponível.</p>
            @endif
        </div>

        <flux:text class="text-gray-500 whitespace-pre-wrap">{{ $article->content }}</flux:text>
    </div>
</div>
