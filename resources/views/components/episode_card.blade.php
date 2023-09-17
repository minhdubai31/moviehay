@props(['episode'])
<a href="/{{$episode->season_id}}" class="relative">
    <img class="w-full h-32 rounded-lg"
        src="{{ $episode->thumbnail ? asset('storage/' . $episode->thumbnail) : asset('images/no-thumbnail.jpg') }}"
        alt="">
    <div class="w-full h-full absolute top-0 left-0 rounded-lg"
        style="background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(9,9,121,0) 80%);"></div>
    <div class="absolute bottom-3 left-3 text-white text-xs">
        <p class="font-semibold">{{ $episode->episode_name }}</p>
        <p>Tập {{ $episode->episode_order }}</p>

    </div>
</a>
