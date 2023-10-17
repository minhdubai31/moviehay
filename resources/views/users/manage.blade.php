<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-16">
        <header class="text-center text-orange-600 pt-2">
            <h2 class="text-2xl font-bold uppercase">Thông tin tài khoản</h2>
        </header>
        <div class="my-6 flex flex-col items-center">
            <img class="rounded-full border-2 border-gray-400 w-36 mb-2 h-36 object-cover"
                src="{{ $this_user->avatar ? asset('storage/' . $this_user->avatar) : asset('images/default_avatar.png') }}"
                id="image-preview1" />
        </div>
        <div class="mb-6">
            <p class="inline-block ps-10 font-bold">Tên người dùng: <span class="ps-2 text-lg font-normal">{{ $this_user->username }}</span></p>
        </div>
        <div class="mb-6">
            <p class="inline-block ps-10 font-bold">Email: <span class="ps-2 text-lg font-normal">{{ $this_user->email }}</span></p>
        </div>

        <div class="flex justify-center pt-5 pb-2">
            <a class="p-3 text-white bg-green-600 rounded-lg  hover:bg-green-800 me-3" href="/users/edit/{{ $this_user->user_id }}">
                <i class="fa-solid fa-pen-to-square pe-2"></i> Chỉnh sửa
            </a>
            <form class="m-0" action="/users/delete/{{ $this_user->user_id }}" method="post">
                @csrf
                @method('DELETE')
                <button type="button"
                    class="delete-btn p-3 text-white bg-red-500 rounded-lg  hover:bg-red-700"><i
                        class="fa-solid fa-trash-can pe-2"></i>Xóa tài khoản</button>
            </form>
        </div>
    </x-card>
</x-layout>
<script>
    $('.delete-btn').each((index, element) => {
        $(element).click((e) => {
            con = confirm('Bạn chắc chắn muốn xóa tài khoản này?');
            if (con) {
                $(element).parent().submit();
            }
        })
    })
</script>
