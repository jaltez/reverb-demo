<main x-data class="bg-gray-800 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-2xl font-bold text-white mb-4">REVERB DEMO</h1>
    <h2 class="text-xl font-bold text-white mb-4">Current User: {{ $username }}</h2>

    <div class="bars w-1/2">
        @foreach ($buttons as $button)
            <div class="bar-container my-2" data-id="{{ $button->id }}">
                <button wire:click="incrementCount({{ $button->id }})" wire:loading.attr="disabled"
                    wire:target="incrementCount({{ $button->id }})"
                    class="text-white text-lg px-4 py-2 rounded-md my-2 bg-gray-500 hover:bg-gray-400">
                    {{ Str::ucfirst($button->name) }}
                </button>
                <span class="text-white">{{ $button->count }}</span>
                <div class="bar bg-slate-300 h-12 rounded-r-sm"
                    style="width: {{ ($button->count / $maxCount) * 100 }}%; height: 20px;">
                </div>
            </div>
        @endforeach
    </div>

    <div class="w-1/2">
        <h2 class="text-xl font-bold text-white mt-4">Events:</h2>
        <ul class="text-sm font-mono text-gray-500 mt-4 h-[20vw] overflow-auto">
            @foreach ($events as $event)
                <li>{{ $event }}</li>
            @endforeach
        </ul>
    </div>
</main>
