@props(['season'])

<a href="/seasons/{{$season->ss_id}}" class="relative">
    <img class="w-full rounded-lg object-cover h-72 border"
        src="{{ $season->ss_poster ? asset('storage/' . $season->ss_poster) : asset('images/no-thumbnail.jpg') }}"
        alt="">
    <div class="w-full h-full absolute top-0 left-0 rounded-lg"
        style="background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(9,9,121,0) 80%);"></div>
    <div class="absolute bottom-3 left-3 text-white w-full">
        <p class="font-medium text-sm uppercase" style="width: 90%;">{{ $season->ss_name }}</p>
    </div>
</a>