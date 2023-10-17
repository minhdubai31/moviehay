@auth
    <div class="flex ms-4 items-center">
        <div id="user-access" class="relative">
            <img class="h-10 w-10 rounded-full border border-gray-400 inline-block object-cover cursor-pointer"
                src=" {{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default_avatar.png') }} "
                alt="">
            <span class="font-bold ps-2 text-orange-600 hover:text-orange-800 cursor-pointer">
                {{ auth()->user()->username }}
            </span>
            <div id="user-setting" hidden
                class="absolute top-12 p-3 w-80 right-0 rounded-lg border-2 bg-white shadow-lg flex-col items-center z-50">
                <p class="py-2 text-sm">{{ auth()->user()->email }}</p>
                <img class="h-28 w-28 rounded-full border border-gray-400 inline-block object-cover"
                    src=" {{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default_avatar.png') }} "
                    alt="">
                <p class="text-xl pt-5 font-bold text-orange-600">Chào {{ auth()->user()->username }}</p>
                @if (auth()->user()->username == 'admin')
                    <a class="my-1 mt-3 p-3 px-8 rounded-lg block text-white/75 bg-orange-800 duration-150"
                        >Quản lý
                        tài khoản</a>
                    <div class="flex gap-2 items-center">
                        <a >
                            <div
                                class="w-32 h-14 my-1 p-3 rounded-lg flex items-center text-gray-200 bg-gray-400 duration-150 align-middle">
                                <i class="fa-solid fa-clock-rotate-left text-xl mx-1.5 me-3"></i>
                                <span>Lịch sử</span>
                            </div>
                        </a>
                    @else
                        <a href="/users/manage/{{ auth()->user()->user_id }}" class="my-1 mt-3 p-3 px-8 rounded-lg block text-white bg-orange-600 hover:bg-orange-800 duration-150"
                            >Quản lý
                            tài khoản</a>
                        <div class="flex gap-2 items-center">
                            <a href="/users/history/{{ auth()->user()->user_id }}">
                                <div
                                    class="w-32 h-14 my-1 p-3 rounded-lg flex items-center bg-gray-200 hover:bg-gray-400 duration-150 align-middle">
                                    <i class="fa-solid fa-clock-rotate-left text-xl mx-1.5 me-3"></i>
                                    <span>Lịch sử</span>
                                </div>
                            </a>
                @endif

                <form class="block" action="/users/logout" method="get">
                    @csrf
                    <button type="submit"
                        class="w-32 h-14 my-1 p-3 rounded-lg flex items-center bg-gray-200 hover:bg-gray-400 duration-150 align-middle">
                        <i class="fa-solid fa-right-from-bracket  text-xl mx-1.5 me-3"></i>
                        <span>
                            Đăng xuất
                        </span>
                    </button>
                </form>
            </div>

        </div>
    </div>
    </div>
@else
    <a class="ps-4" href="/users/login">
        <span class="border-2 text-orange-600 border-orange-500 rounded-lg p-2.5 h-10 ms-2">Đăng nhập</span>
    </a>
@endauth

<script>
    $('#user-access').click((e) => {
        $('#user-setting').slideToggle(300).css('display', 'flex');
    });
    $(document).mouseup(function(e) {
        var container = $("#user-setting");
        var userIcon = $('#user-access');
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0 && !userIcon.is(e.target) &&
            userIcon.has(e.target).length === 0) {
            $(container).slideUp(300);
        }
    });
</script>
