@props(['episode', 'thumb_height', 'thumb_width'])

@php
    $thumb_h = $thumb_height ?? '36';
    $thumb_w = $thumb_width ?? '40';
@endphp

@foreach ($episode->season->episodes->sortBy('ep_order') as $item)
    <a href="/episodes/{{ $item->ep_id }}" class="flex mb-2">
        <div class="relative min-w-max">
            <img class="{{ 'w-' . $thumb_w }} {{ 'h-' . $thumb_h }} rounded-lg border object-cover"
                src="{{ $item->ep_thumbnail ? asset('storage/' . $item->ep_thumbnail) : asset('images/no-thumbnail.jpg') }}"
                alt="">
            <p
                class="absolute top-0 left-0 rounded-br-xl rounded-tl-lg bg-orange-600 text-white text-xs font-bold py-1 px-3">
                {{ $item->ep_order }}</p>
        </div>
        <div class=" pt-2 ps-3 @if ($item->ep_id == $episode->ep_id) text-orange-600 @endif">
            <p class="font-semibold">
                Tập {{ $item->ep_order }}
                @isset($episode->ep_name)
                    {{ ' - ' . $episode->ep_name }}
                @endisset
            </p>
            <p class="text-xs pt-1">
                {{ number_format($item->views->count(), 0, '', '.') . ' lượt xem' }}
            </p>
        </div>
    </a>
@endforeach
