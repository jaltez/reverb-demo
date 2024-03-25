<main>
    <template id="circle-template">
        <div class="dot w-5 h-5 rounded-full absolute opacity-50"></div>
    </template>

    @script
        <script>
            document.addEventListener('click', function(event) {
                @this.call('userClick', event.clientX, event.clientY);
            });

            document.addEventListener('renderClick', event => {
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

    <div class="m-8">
        <h1 class="text-2xl font-bold text-slate-700 mb-4">REVERB DEMO</h1>

        <h2 class="text-xl font-bold text-slate-700 mb-4">Current User: {{ $username }}</h2>

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
</main>
