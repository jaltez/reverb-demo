<div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-5">
    <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">Recent Activity</h3>
    <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
        @foreach(array_reverse($activities) as $activity)
            <div class="bg-white/5 border border-white/5 rounded-xl p-3">
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full shadow-md" style="background-color: {{ $activity['data']['color'] }}; box-shadow: 0 0 8px {{ $activity['data']['color'] }}40"></div>
                        <span class="text-slate-200 text-sm font-medium">{{ $activity['data']['username'] }}</span>
                    </div>
                    <span class="text-slate-500 text-xs">{{ $activity['timestamp'] }}</span>
                </div>
                <p class="text-slate-400 text-xs">
                    <span class="{{ $activity['data']['isChecked'] ? 'text-emerald-400' : 'text-slate-500' }}">
                        {{ $activity['data']['isChecked'] ? 'filled' : 'cleared' }}
                    </span>
                    pixel ({{ $activity['data']['row'] }}, {{ $activity['data']['column'] }})
                </p>
            </div>
        @endforeach
        @if(count($activities) === 0)
            <p class="text-slate-500 text-sm text-center py-4">No activity yet</p>
        @endif
    </div>
</div>
