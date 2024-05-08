<main x-data class="bg-gray-800 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-2xl font-bold text-white mb-4">REVERB DEMO</h1>
    <h2 class="text-xl font-bold text-white mb-4">Generated user: {{ $username }}</h2>

    <div class="w-1/2">
        <div class="rounded-3xl bg-gray-900 p-8">
            <div class="bars">
                @foreach ($buttons as $button)
                    <div class="my-6 flex items-center" data-id="{{ $button->id }}">
                        <button
                            class="font-semi w-20 rounded-md bg-gray-500 px-4 py-2 text-lg text-white hover:bg-gray-400 hover:text-slate-700 disabled:bg-gray-600"
                            wire:click="incrementCount({{ $button->id }})" wire:loading.attr="disabled"
                            wire:target="incrementCount({{ $button->id }})">
                            {{ Str::ucfirst($button->name) }}
                        </button>
                        <div class="flex flex-1 flex-col ml-4">
                            <div class="bar bg-slate-300 h-12 rounded-md"
                                style="width: {{ ($button->count / $maxCount) * 100 }}%; height: 20px;">
                            </div>
                            <div class="flex gap-2 items-center">
                                <div class="text-xl font-semibold text-white">
                                    {{ $button->count }}
                                    </span>
                                </div>
                                <div wire:target="incrementCount({{ $button->id }})" wire:loading>
                                    <svg class="animate-spin float-right h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.963 7.963 0 014 12H0c0 3.042 1.135 5.824 3.009 7.775L6 17.29z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <h2 class="text-xl font-bold text-white mt-4">Events:</h2>
        <ul class="text-sm font-mono text-gray-500 mt-4 h-[20vw] overflow-auto">
            @foreach ($events as $event)
                <li>{{ $event }}</li>
            @endforeach
        </ul>
    </div>
</main>
