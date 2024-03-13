<div wire:click=''>
    <h1>REVERB DEMO</h1>
    {{-- <button @click="$dispatch('UserConnected')">Button</button> --}}
    <div>
        <ul>
            @foreach ($logs as $log)
                <li>
                    {{ $log }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
