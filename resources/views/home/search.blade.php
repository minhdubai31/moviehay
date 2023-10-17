<x-layout>
    <h1 class="font-medium text-2xl py-10 pb-0 text-orange-600 w-full uppercase">Kết quả tìm kiếm: <span
            class="italic normal-case font-light text-gray-700">{{ Request::get('search') }}</span> </h1>
    @if ($series->count() != 0)
        <h1 class="uppercase py-5 font-bold text-lg inline-block">Series</h1>
        <div class="grid grid-cols-5 gap-4">

            @foreach ($series as $seri)
                <x-seri_card :seri="$seri" />
            @endforeach
        </div>
    @endif
    @if ($seasons->count() != 0)
        <h1 class="uppercase py-5 font-bold text-lg inline-block">Seasons</h1>
        <div class="grid grid-cols-5 gap-4">
            @foreach ($seasons as $season)
                <x-season_card :season="$season" />
            @endforeach
        </div>
    @endif
    @if ($series->count() == 0 && $seasons->count() == 0)
        <p class="text-xl pt-5">Rất tiếc chúng tôi, không tìm thấy phim bạn cần.</p>
    @endif
</x-layout>
