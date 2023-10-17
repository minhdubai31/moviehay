@props(['episode', 'thumb_height'])
@php
    $thumb_h = $thumb_height ?? '36';
@endphp

<a href="/episodes/{{ $episode->ep_id }}" class="relative">
    <img class="w-full rounded-lg object-cover border {{ 'h-' . $thumb_h }}"
        src="{{ $episode->ep_thumbnail ? asset('storage/' . $episode->ep_thumbnail) : asset('images/no-thumbnail.jpg') }}"
        alt="">
    <div class="w-full h-full absolute top-0 left-0 rounded-lg"
        style="background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(9,9,121,0) 80%);"></div>
    <div class="absolute bottom-3 left-3 text-white w-full">
        <p class="font-medium text-sm truncate uppercase" style="width: 90%;">{{ $episode->season->ss_name }}</p>
        <p class="font-light text-xs truncate" style="width: 90%;">Tập {{ $episode->ep_order }}
            @isset($episode->ep_name)
                {{ ' - ' . $episode->ep_name }}
            @endisset
        </p>
    </div>
</a>
