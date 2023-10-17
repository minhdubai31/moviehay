<x-layout>
    <h1 class="font-medium text-3xl py-10 text-orange-600 text-center w-full uppercase">Phim bộ</h1>
    <div class="grid grid-cols-6 gap-4">     
        @foreach ($seriesmovies as $season)
            <x-season_card :season="$season"/>
        @endforeach
    </div>
    {{ $seriesmovies->links() }}
</x-layout>
