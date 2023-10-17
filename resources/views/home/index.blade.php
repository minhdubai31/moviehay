<x-layout>
    <x-carousel :seasons_by_view="$seasons_by_view" />
    <h1 class="uppercase py-5 font-bold text-lg inline-block">Mới cập nhật</h1>
    <span>
        <i class="fa-solid fa-chevron-right text-xs px-3"></i>
        <a class="text-sm font-semibold text-orange-600" href="/episodes/recent">Xem tất cả</a>
    </span>

    <div class="grid grid-cols-5 gap-4">
        @foreach ($episodes_new as $episode)
            <x-episode_card :episode="$episode" />
        @endforeach
    </div>
    <h1 class="uppercase py-5 font-bold text-lg inline-block">Xem gì hôm nay</h1>
    <span>
        <i class="fa-solid fa-chevron-right text-xs px-3"></i>
        <a class="text-sm font-semibold text-orange-600" href="/seasons/random">Xem tất cả</a>
    </span>

    <div class="grid grid-cols-6 gap-4">
        @foreach ($seasons_random as $season)
            <x-season_card :season="$season" />
        @endforeach
    </div>

    <h1 class="uppercase py-5 font-bold text-lg inline-block">Bảng xếp hạng</h1>
    <div class="bg-gray-800 rounded-lg">
        @foreach ($seasons_by_view as $item)
            @if ($loop->first)
                <div class="first">
                    <div class="relative overflow-hidden rounded-t-lg">
                        <img class="w-full h-48 rounded-t-lg object-cover"
                            src="{{ $item[0]->season->ss_bg ? asset('storage/' . $item[0]->season->ss_bg) : asset('images/preview.jpg') }}"
                            alt="" srcset="">
                        <div class="absolute text-4xl left-10 top-1/2 transform -translate-y-1/2">
                            <i class="fa-solid fa-crown text-yellow-300 drop-shadow p-3 bg-white/30 rounded-lg backdrop-blur-lg"></i>

                            <a href="/seasons/{{ $item[0]->season->ss_id }}">
                                <div class="ms-10 bg-white/30 backdrop-blur-lg rounded-lg  shadow p-5 inline-block">
                                    <img class="h-28 rounded-lg inline-block me-5"
                                    src="{{ $item[0]->season->ss_poster ? asset('storage/' . $item[0]->season->ss_poster) : asset('images/no-thumbnail.jpg') }}"
                                    alt="">
                                    <h2 class="text-2xl font-bold uppercase text-white drop-shadow inline-block">
                                        {{ $item[0]->season->ss_name }}
                                        <p class="text-xs font-light normal-case">{{ $item[0]->season->ss_categories }}</p>
                                    </h2>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <hr class="border-white/10">
                <div class="relative py-14">
                    <div class="p-5 ps-10 absolute top-1/2 transform -translate-y-1/2">
                        <div class="inline-block w-10">
                            <span class="text-xl font-bold text-orange-600">{{ $loop->index + 1 }}</span>
                        </div>
                        <a href="/seasons/{{ $item[0]->season->ss_id }}">
                            <img class="h-20 ms-4 rounded border border-white/25 object-cover inline-block"
                                src="{{ $item[0]->season->ss_poster ? asset('storage/' . $item[0]->season->ss_poster) : asset('images/no-thumbnail.jpg') }}"
                                alt="" srcset="">
                            <span class="text-white text ms-4 inline-block">
                                <p class="font-bold text-lg">
                                    {{ $item[0]->season->ss_name ?? 'Unknow' }}
                                </p>
                                <p class="text-xs font-light">{{ $item[0]->season->ss_categories }}</p>
                            </span>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</x-layout>
