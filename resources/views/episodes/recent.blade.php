<x-layout>
    <h1 class="font-medium text-3xl py-10 text-orange-600 text-center w-full uppercase">Mới cập nhật</h1>
    <div class="grid grid-cols-5 gap-4">     
        @foreach ($episodes as $episode)
            <x-episode_card :episode="$episode"/>
        @endforeach
    </div>
    {{ $episodes->appends(request()->input())->links() }}
</x-layout>
