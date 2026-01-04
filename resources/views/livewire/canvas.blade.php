<div x-data class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 p-4 md:p-8">
    <!-- Header -->
    <header class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-2">
                Pixel Canvas
            </h1>
            <p class="text-slate-400 text-lg">A Laravel Reverb demo with real-time updates.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-4 h-4 rounded-full ring-2 ring-white/20"
                style="background-color: {{ $color }}; box-shadow: 0 0 16px {{ $color }}60"></div>
            <span class="text-slate-300 font-medium">{{ $username }}</span>
        </div>
    </header>

    <!-- Stats Bar -->
    <div class="max-w-7xl mx-auto mb-8 grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
            <div class="text-3xl font-bold text-white mb-1">{{ $totalChecked }}</div>
            <div class="text-xs text-slate-400 uppercase tracking-wider">Pixels Filled</div>
        </div>
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
            <div class="text-3xl font-bold text-white mb-1">{{ number_format($totalClicks) }}</div>
            <div class="text-xs text-slate-400 uppercase tracking-wider">Total Clicks</div>
        </div>
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
            <div class="text-3xl font-bold text-emerald-400 mb-1">{{ count($onlineUsers) }}</div>
            <div class="text-xs text-slate-400 uppercase tracking-wider">Online Now</div>
        </div>
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
            <div class="text-3xl font-bold text-violet-400 mb-1">
                {{ round(($totalChecked / ($rows * $columns)) * 100, 1) }}%</div>
            <div class="text-xs text-slate-400 uppercase tracking-wider">Complete</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Canvas Area -->
        <div class="lg:col-span-3">
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-4 shadow-2xl shadow-black/50">
                <div class="grid gap-0.5" style="grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr))">
                    @foreach ($cells as $cell)
                        <div @class([
                            'aspect-square transition-all duration-150 cursor-pointer relative overflow-hidden rounded-sm',
                            'hover:scale-105 hover:z-10',
                        ])
                            @if ($cell['isChecked']) style="background-color: {{ $cell['color'] }}; box-shadow: 0 0 20px {{ $cell['color'] }}40"
                            @else
                                style="background-color: rgba(255, 255, 255, 0.02)" @endif
                            wire:click="toggleCell({{ $cell['row'] }}, {{ $cell['column'] }})"
                            wire:key="cell-{{ $cell['row'] }}-{{ $cell['column'] }}" wire:loading.attr="disabled"
                            wire:target="toggleCell({{ $cell['row'] }}, {{ $cell['column'] }})"
                            title="Row: {{ $cell['row'] }}, Column: {{ $cell['column'] }}, Clicks: {{ $cell['clickCount'] }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Online Artists -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-5">
                <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Online Artists
                </h3>
                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                    @foreach ($onlineUsers as $user)
                        <div class="flex items-center gap-3 p-2 rounded-xl bg-white/5 border border-white/5">
                            <div class="w-4 h-4 rounded-full shadow-lg"
                                style="background-color: {{ $user['color'] }}; box-shadow: 0 0 12px {{ $user['color'] }}60">
                            </div>
                            <span class="text-slate-200 text-sm font-medium truncate">{{ $user['username'] }}</span>
                        </div>
                    @endforeach
                    @if (count($onlineUsers) === 0)
                        <p class="text-slate-500 text-sm text-center py-4">No one else is here</p>
                    @endif
                </div>
            </div>

            <!-- Activity Feed -->
            @livewire('canvas-activity-feed')
        </div>
    </div>
</div>

@script
    <script>
        document.addEventListener('livewire:init', function() {
            console.log('Livewire initialized');

            // Join the presence channel
            @this
                .wireMe
                .joinPresence('canvas.presence')
                .here((users) => {
                    console.log('Presence channel - here:', users);
                    @this.set('onlineUsers', users);
                })
                .joining((user) => {
                    console.log('Presence channel - joining:', user);
                    @this.call('onPresenceJoining', user);
                })
                .leaving((user) => {
                    console.log('Presence channel - leaving:', user);
                    @this.call('onPresenceLeaving', user);
                });

            // Listen to the public canvas channel for cell toggled events
            window.Echo.channel('canvas')
                .listen('.cell.toggled', (e) => {
                    console.log('Cell toggled event received:', e);
                    @this.call('onCellToggled', e);
                });
        });
    </script>
@endscript
