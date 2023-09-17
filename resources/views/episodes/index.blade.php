<x-layout>
    <div class="grid grid-cols-5 gap-4">     
        @foreach ($episodes as $episode)
            <x-episode_card :episode="$episode"/>
        @endforeach
    </div>
</x-layout>
