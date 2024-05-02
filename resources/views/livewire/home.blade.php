<main x-data class="bg-gray-800 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-2xl font-bold text-white mb-4">REVERB DEMO</h1>
    <h2 class="text-xl font-bold text-white mb-4">Generated user: {{ $username }}</h2>

    <div class="w-3/4 lg:w-1/2">
        <div class="bars">
            @foreach ($buttons as $button)
                <div class="my-6 flex items-center" data-id="{{ $button->id }}">
                    <button
                        class="text-white text-lg px-4 py-2 rounded-md w-20 bg-gray-500 hover:bg-gray-400 disabled:bg-gray-600"
                        wire:click="incrementCount({{ $button->id }})" wire:loading.attr="disabled"
                        wire:target="incrementCount({{ $button->id }})">
                        {{ Str::ucfirst($button->name) }}
                    </button>
                    <div class="flex-1 flex flex-col ml-4">
                        <div class="bar bg-slate-300 h-12 rounded-r-sm"
                            style="width: {{ ($button->count / $maxCount) * 100 }}%; height: 20px;">
                        </div>
                        <span class="text-white text-xl">{{ $button->count }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <h2 class="text-xl font-bold text-white mt-4">Events:</h2>
        <ul class="text-sm font-mono text-gray-500 mt-4 h-[20vw] overflow-auto">
            @foreach ($events as $event)
                <li>{{ $event }}</li>
            @endforeach
        </ul>
    </div>
</main>
