<main class="bg-gray-800 min-h-screen flex flex-col items-center justify-center">

    <h1 class="text-2xl font-bold text-white mb-4">REVERB DEMO</h1>

    <h2 class="text-xl font-bold text-white mb-4">Current User: {{ $username }}</h2>

    @script
        <script>
            Echo.channel('everyone')
                .listen('.user.voted', (event) => {
                    console.log(event);
                    const barContainer = document.querySelector(`.bar-container[data-id="${event.buttonId}"]`);
                    const bar = barContainer.querySelector('.bar');
                    const newWidth = (event.count / {{ $maxCount }}) * 100;
                    bar.style.width = `${newWidth}%`;
                });
        </script>
    @endscript

    <div class="bars w-1/2">
        @if ($buttons)
            @foreach ($buttons as $button)
                <div class="bar-container my-2" data-id="{{ $button->id }}">
                    <button wire:click="incrementCount({{ $button->id }})"
                        class="text-white text-lg px-4 py-2 rounded-md my-2 bg-gray-500 hover:bg-gray-400">
                        {{ Str::ucfirst($button->name) }}
                    </button>
                    <span class="text-white">{{ $button->count }}</span>
                    <div class="bar bg-slate-300 h-12 rounded-r-sm"
                        style="width: {{ ($button->count / $maxCount) * 100 }}%; height: 20px;">
                    </div>
                </div>
            @endforeach
        @endif
    </div>



    <div class="w-1/2">
        <h2 class="text-xl font-bold text-white mt-4">Events:</h2>
        <ul class="list-inside text-sm font-mono text-gray-500 mt-4 h-[20vw] overflow-auto">
            @foreach ($events as $event)
                <li>
                    {{ $event }}
                </li>
            @endforeach
        </ul>
    </div>
</main>
