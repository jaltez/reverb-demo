<main class="bg-gray-800 min-h-screen flex flex-col items-center justify-center">

    <template id="circle-template">
        <div class="dot w-5 h-5 rounded-full absolute opacity-70"></div>
    </template>

    @script
        <script>
            document.getElementById('click-area').addEventListener('click', function(event) {
                @this.call('userClick', event.clientX, event.clientY);
            });

            window.addEventListener('renderClick', event => {
                const template = document.getElementById('circle-template');
                const cloned = template.content.cloneNode(true);
                const dot = cloned.querySelector('.dot');
                dot.style.backgroundColor = event.detail[0].color;
                dot.style.left = `${event.detail[0].x - 10}px`;
                dot.style.top = `${event.detail[0].y - 10}px`;
                document.body.appendChild(cloned);
            });
        </script>
    @endscript

    <h1 class="text-2xl font-bold text-white mb-4">REVERB DEMO</h1>

    <h2 class="text-xl font-bold text-white mb-4">Current User: {{ $username }}</h2>


    <div id="click-area" class="w-1/2 h-[30vw] bg-gray-700 flex items-center justify-center rounded-xl"></div>

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

    <div>
        {{-- <div class="grid grid-cols-2 gap-4">

                <div class="my-5 p-4 border border-slate-300 rounded-md">
                    <h2 class="text-xl font-bold text-white mb-4">Events:</h2>
                    <ul class="list-disc list-inside">
                        @foreach ($events as $event)
                            <li>
                                {{ $event }}
                            </li>
                        @endforeach
                    </ul>
                </div>


                <div id="click-area" class="m-5 p-4 border border-slate-300 rounded-md min-h-screen bg-gray-100">
                </div>
            </div> --}}
    </div>
</main>
