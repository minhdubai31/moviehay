<x-layout>
    <div class="inline-flex w-full flex-wrap">
        <h1 class="font-medium text-3xl py-10 text-orange-600 text-center w-full">Danh sách người dùng</h1>
        <div class="search-bar mb-2">
            <form action="" method="GET">
                <div class="search-bar-container relative inline-block">
                    <input class="border-2 rounded-lg p-3 w-96 h-10 outline-gray-500" type="text" name="search"
                        placeholder="Tìm theo tên người dùng, email" autocomplete="off"
                        value="{{ Request::get('search') }}">
                    <button type="submit" class="absolute right-3  top-1/2 transform -translate-y-1/2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                @if (Request::get('search'))
                    <a class="ms-1 p-3 rounded-lg text-white bg-red-500" href="/admin/users">Hủy</a>
                @endif
            </form>
        </div>
        <table class="text-sm w-full text-left text-gray-500 dark:text-gray-400 rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                <tr>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Username
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                        <div class="flex justify-between items-center">
                            Email
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 border-gray-400 border">
                    </th>
                </tr>
                </tr>
            </thead>
            <tbody class="text-gray-500">
                @foreach ($users as $user)
                    @if ($user->username != 'admin')
                        <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-3 border-gray-400 border">
                                {{ $user->username }}
                            </td>
                            <td class="px-6 py-3 border-gray-400 border">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-3 border-gray-400 border text-center">
                                <form class="m-0" action="/users/delete/{{ $user->user_id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="delete-btn p-1 text-red-500 rounded text-lg hover:text-red-700"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->appends(request()->input())->links() }}
</x-layout>
<script>
    $('.delete-btn').each((index, element) => {
        $(element).click((e) => {
            con = confirm('Bạn chắc chắn muốn xóa người dùng ' + $(element).parent().parent().siblings(
                    'td').first().text()
                .trim() + '?');
            if (con) {
                $(element).parent().submit();
            }
        })
    })
</script>
