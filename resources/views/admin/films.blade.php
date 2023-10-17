<x-layout>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <div class="inline-flex w-full flex-wrap">
        <h1 class="font-medium text-3xl py-10 text-orange-600 text-center w-full">Danh sách phim</h1>
        <div class="search-bar mb-2">
            <form action="" method="GET">
                <div class="search-bar-container relative inline-block">
                    <input class="border-2 rounded-lg p-3 w-96 h-10 outline-gray-500" type="text" name="search"
                        placeholder="Tìm theo tên seri, season" autocomplete="off" value="{{ Request::get('search') }}">
                    <button type="submit" class="absolute right-3  top-1/2 transform -translate-y-1/2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                @if (Request::get('search'))
                    <a class="ms-1 p-3 rounded-lg text-white bg-red-500" href="/admin/films">Hủy</a>
                @endif
            </form>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                <tr>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Series
                            <a href="/admin/series/create" class="bg-orange-600 p-2 px-3 text-white rounded-lg"><i
                                    class="fa-solid fa-plus"></i></a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Seasons
                            <a href="/admin/seasons/create" class="bg-orange-600 p-2 px-3 text-white rounded-lg"><i
                                    class="fa-solid fa-plus"></i></a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Tập phim
                            <a href="/admin/episodes/create" class="bg-orange-600 p-2 px-3 text-white rounded-lg"><i
                                    class="fa-solid fa-plus"></i></a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-500">
                @foreach ($series as $seri)
                    @php
                        $seri_rowspan = 0;
                        foreach ($seri->seasons as $season) {
                            $seri_rowspan += $season->episodes->count();
                            if ($season->episodes->count() == 0) {
                                $seri_rowspan += 1;
                            }
                        }
                    @endphp
                    @foreach ($seri->seasons as $season)
                        @foreach ($season->episodes as $episode)
                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                                @if ($loop->first)
                                    @if ($loop->parent->first)
                                        <td class="px-6 py-3 border-gray-400 border font-semibold"
                                            rowspan="{{ $seri_rowspan }}">
                                            <div class="flex items-center">
                                                <img class="border inline-block h-20 rounded me-2"
                                                    src="{{ $seri->sr_poster ? asset('storage/' . $seri->sr_poster) : asset('images/no-thumbnail.jpg') }}"
                                                    alt="">
                                                <span class="grow">
                                                    {{ $seri->sr_name }}
                                                </span>
                                                <a href="/admin/series/edit/{{ $seri->sr_id }}"
                                                    class="p-1 mx-1 text-green-600 text-lg rounded hover:text-green-800">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form class="m-0" action="/series/delete/{{ $seri->sr_id }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                @endif
                                @if ($loop->first)
                                    <td class="px-6 py-3 border-gray-400 border"
                                        rowspan="{{ $season->episodes->count() }}">
                                        <div class="flex items-center">
                                            <img class="border inline-block h-20 rounded me-2"
                                                src="{{ $season->ss_poster ? asset('storage/' . $season->ss_poster) : asset('images/no-thumbnail.jpg') }}"
                                                alt="">
                                            <span class="grow">
                                                {{ $season->ss_name }}
                                            </span>
                                            <a href="/admin/seasons/edit/{{ $season->ss_id }}"
                                                class="p-1 mx-1 text-green-600 text-lg rounded hover:text-green-800">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form class="m-0" action="/seasons/delete/{{ $season->ss_id }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                                        class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                @endif

                                <td class="px-6 py-3 border-gray-400 border">
                                    <div class="flex items-center">
                                        <span class="grow">
                                            Tập {{ $episode->ep_order }}: {{ $episode->ep_name }}
                                        </span>
                                        <a href="/admin/episodes/edit/{{ $episode->ep_id }}"
                                            class="p-1 mx-1 text-green-600 text-lg rounded hover:text-green-800">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form class="m-0" action="/episodes/delete/{{ $episode->ep_id }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($season->episodes->count() == 0)
                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                                @if ($loop->first)
                                    @if ($seri->seasons->count() >= 1)
                                        <td class="px-6 py-3 border-gray-400 border font-semibold"
                                            rowspan="{{ $seri->seasons->count() }}">
                                            <div class="flex items-center">
                                                <img class="border inline-block h-20 rounded me-2"
                                                    src="{{ $seri->sr_poster ? asset('storage/' . $seri->sr_poster) : asset('images/no-thumbnail.jpg') }}"
                                                    alt="">
                                                <span class="grow">
                                                    {{ $seri->sr_name }}
                                                </span>
                                                <a href="/admin/series/edit/{{ $seri->sr_id }}"
                                                    class="p-1 mx-1 text-green-600 text-lg rounded hover:text-green-800">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form class="m-0" action="/series/delete/{{ $seri->sr_id }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                @endif
                                <td class="px-6 py-3 border-gray-400 border">
                                    <div class="flex items-center">
                                        <img class="border inline-block h-20 rounded me-2"
                                            src="{{ $season->ss_poster ? asset('storage/' . $season->ss_poster) : asset('images/no-thumbnail.jpg') }}"
                                            alt="">
                                        <span class="grow">
                                            {{ $season->ss_name }}
                                        </span>
                                        <a href="/admin/seasons/edit/{{ $season->ss_id }}"
                                            class="p-1 mx-1 text-green-600 text-lg rounded hover:text-green-800">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form class="m-0" action="/seasons/delete/{{ $season->ss_id }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-3 border-gray-400 border">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if ($seri->seasons->count() == 0)
                        <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-3 border-gray-400 border font-semibold">
                                <div class="flex items-center">
                                    <img class="border inline-block h-20 rounded me-2"
                                        src="{{ $seri->sr_poster ? asset('storage/' . $seri->sr_poster) : asset('images/no-thumbnail.jpg') }}"
                                        alt="">
                                    <span class="grow">
                                        {{ $seri->sr_name }}
                                    </span>
                                    <a href="/admin/series/edit/{{ $seri->sr_id }}"
                                        class="p-1 mx-1 text-green-600 text-lg rounded hover:text-green-800">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form class="m-0" action="/series/delete/{{ $seri->sr_id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-6 py-3 border-gray-400 border">
                            </td>
                            <td class="px-6 py-3 border-gray-400 border">
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $series->appends(request()->input())->links() }}
</x-layout>
<script>
    // Resizable table column
    $(function() {
        var prevWidth;
        var thHeight = $("table th:first").height();
        $("table th:not(:last-child)").resizable({
            handles: "e",
            minHeight: thHeight,
            maxHeight: thHeight,
            minWidth: 40,
            start: function(event, ui) {
                if (prevWidth == undefined) {
                    prevWidth = ui.element.prev().width();
                }
            },
            resize: function(event, ui) {
                ui.element.prev().width(prevWidth);
            },
            stop: function(event, ui) {
                prevWidth = undefined;
            }
        });
    });

    $('.delete-btn').each((index, element) => {
        $(element).click((e) => {
            con = confirm('Bạn chắc chắn muốn xóa ' + $(element).parent().siblings('span').text()
            .trim() + '?');
            if (con) {
                $(element).parent().submit();
            }
        })
    })
</script>
