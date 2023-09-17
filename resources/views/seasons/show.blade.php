<x-layout>
    <x-season_info :season="$season"/>
    <a class="py-2 px-5 my-4 rounded-lg text-white bg-orange-600 inline-block hover:font-semibold" href="">{{$season->season_tag}}</a>
    <div class="grid grid-cols-6 gap-4"> 
        @foreach ($episodes_list as $episode)
            <x-episode_card :episode="$episode"/>
        @endforeach
    </div>
</x-layout>
