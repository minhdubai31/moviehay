<x-layout>
    <x-season_info :season="$season" />
    @foreach ($season->seri->seasons->sortBy('ss_release_date') as $item)
        <a class="py-2 px-5 my-4 mr-2 rounded-lg border-2 border-orange-600 inline-block hover:font-semibold
                @if ($item->ss_id == $season->ss_id) 
                    {{ 'text-white  bg-orange-600' }} 
                @else
                    {{ 'text-orange-600 bg-white' }} 
                @endif  
            "
            href="/seasons/{{ $item->ss_id }}">
            {{ $item->ss_tag }}
        </a>
    @endforeach
    <div class="grid grid-cols-6 gap-4">
        @foreach ($season->episodes->sortBy('ep_order') as $episode)
            <x-episode_card :episode="$episode" :thumb_height=32 />
        @endforeach
    </div>
</x-layout>
