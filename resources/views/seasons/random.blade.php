<x-layout>
    <h1 class="font-medium text-3xl py-10 text-orange-600 text-center w-full uppercase">Xem gì hôm nay</h1>
    <div class="grid grid-cols-6 gap-4">     
        @foreach ($seasons as $season)
            <x-season_card :season="$season"/>
        @endforeach
    </div>
    {{ $seasons->links() }}
</x-layout>
