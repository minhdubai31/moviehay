<x-layout>
    <div class="inline-flex w-full flex-wrap">
        <h1 class="font-medium text-3xl py-10 text-orange-600 text-center w-full">Danh sách bình luận</h1>
        <div class="search-bar mb-2">
            <form action="" method="GET">
                <div class="search-bar-container relative inline-block">
                    <input class="border-2 rounded-lg p-3 w-96 h-10 outline-gray-500" type="text" name="search"
                        placeholder="Tìm theo tên người dùng, bình luận, season phim" autocomplete="off"
                        value="{{ Request::get('search') }}">
                    <button type="submit" class="absolute right-3  top-1/2 transform -translate-y-1/2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                @if (Request::get('search'))
                    <a class="ms-1 p-3 rounded-lg text-white bg-red-500" href="/admin/comments">Hủy</a>
                @endif
            </form>
        </div>
        <table class="text-sm w-full text-left text-gray-500 dark:text-gray-400 rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                <tr>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Season
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Tập phim
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Người dùng
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Nội dung
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Thời gian
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-500">
                @foreach ($comments as $comment)
                    <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-3 border-gray-400 border">
                            {{ $comment->episode->season->ss_name }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border">
                            {{ 'Tập ' . $comment->episode->ep_order . ': ' . $comment->episode->ep_name }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border">
                            {{ $comment->user->username }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border cmt-content">
                            {{ $comment->cmt_content }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border cmt-time">
                            {{ $comment->updated_at }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border text-center">
                            <form class="m-0" action="/comments/delete/{{ $comment->cmt_id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @foreach ($replycomments as $replycomment)
                    <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-3 border-gray-400 border">
                            {{ $replycomment->comment->episode->season->ss_name }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border">
                            {{ 'Tập ' . $replycomment->comment->episode->ep_order . ': ' . $replycomment->comment->episode->ep_name }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border">
                            {{ $replycomment->user->username }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border cmt-content">
                            {{ $replycomment->rcmt_content }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border cmt-time">
                            {{ $replycomment->updated_at }}
                        </td>
                        <td class="px-6 py-3 border-gray-400 border text-center">
                            <form class="m-0" action="/replycomments/delete/{{ $replycomment->rcmt_id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $comments->appends(request()->input())->links('components.comment_links', [
        'rfirst' => $replycomments->firstItem(),
        'rlast' => $replycomments->lastItem(),
        'rtotal' => $replycomments->total()
        ]) }}

</x-layout>
<script>
    $('.delete-btn').each((index, element) => {
        $(element).click((e) => {
            con = confirm('Bạn chắc chắn muốn xóa bình luận "' + $(element).parent().parent().siblings(
                    '.cmt-content').text()
                .trim() + ' - ' + $(element).parent().parent().siblings(
                    '.cmt-time').text().trim() + '"?');
            if (con) {
                $(element).parent().submit();
            }
        })
    })
</script>
