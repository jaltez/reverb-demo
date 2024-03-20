<div class="m-8">
    <h1 class="text-2xl font-bold text-slate-700 mb-4">REVERB DEMO</h1>

    <h2 class="text-xl font-bold text-slate-700 mb-4">Current User: {{ $username }}</h2>

    <button class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded" wire:click="buttonClick">
        Click
    </button>

    <div>
        <div class="grid grid-cols-2 gap-4">
            <div class="my-5 p-4 border border-slate-300 rounded-md">
                <h2 class="text-xl font-bold text-slate-700 mb-4">Actions:</h2>
                <ul class="list-disc list-inside">
                    @foreach ($actions as $action)
                        <li>
                            {{ $action }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="my-5 p-4 border border-slate-300 rounded-md">
                <h2 class="text-xl font-bold text-slate-700 mb-4">Events:</h2>
                <ul class="list-disc list-inside">
                    @foreach ($events as $event)
                        <li>
                            {{ $event }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
