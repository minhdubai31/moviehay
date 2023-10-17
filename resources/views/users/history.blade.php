<x-layout>
    <h1 class="font-medium text-3xl py-10 text-orange-600 text-center w-full uppercase grow">Lịch sử truy cập</h1>
    <div>
        @foreach ($user->views->sortByDesc('created_at')->groupBy(function ($item) {
        return $item->created_at->format('d-m-Y');
    }) as $key => $item)
            <p class="font-bold text-lg">Ngày {{ $key }}</p>
            <div class="grid grid-cols-5 gap-4">
                @foreach ($item->groupBy('ep_id') as $view)
                    <div>
                        <x-episode_card :episode="$view[0]->episode" />
                        <p class="text-xs text-gray-500 float-right pe-4">{{ $view[0]->created_at->format('h:i a')}}</p>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-layout>
