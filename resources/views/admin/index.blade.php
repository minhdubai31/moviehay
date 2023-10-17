<x-layout>

    <div class="bg-gray-50 mt-3 rounded-lg inline-flex w-full gap-5 p-5 px-20 flex-wrap border-2 border-gray-200">
        <header class="text-center text-orange-600 pt-2 w-full">
            <h2 class="text-2xl font-bold uppercase">Số liệu thống kê</h2>
        </header>
        <div class="bg-gray-300 p-20 py-14 text-center rounded-lg inline-block">
            <p class="text-lg uppercase">Người dùng đăng ký</p>
            <p class="leading-none font-light pt-3" style="font-size: 3rem">{{ number_format($total_users, 0, '', '.') }}</p>
        </div>
        <div class="bg-yellow-500/25 p-20 py-14 text-center rounded-lg inline-block flex-grow">
            <p class="text-lg uppercase px-10">Tổng lượt xem</p>
            <p class="leading-none font-light pt-3" style="font-size: 3rem">{{ number_format($total_views, 0, '', '.') }}</p>
        </div>
        <div class="bg-red-500/20 p-20 py-14 text-center rounded-lg inline-block flex-grow">
            <p class="text-lg uppercase">Tổng lượt yêu thích</p>
            <p class="leading-none font-light pt-3" style="font-size: 3rem">{{ number_format($total_likes, 0, '', '.') }}</p>
        </div>
        <div class="bg-cyan-500/25 p-20 py-14 text-center rounded-lg inline-block">
            <p class="text-lg uppercase">Tổng lượt bình luận</p>
            <p class="leading-none font-light pt-3" style="font-size: 3rem">{{ number_format($total_comments, 0, '', '.') }}</p>
        </div>
    </div>
    <ul class="inline-flex w-full justify-center mt-5">
        <a href="/admin/films"><li class="p-4 px-7 bg-orange-600 hover:bg-orange-700 duration-200 hover:cursor-pointer w-44 text-center rounded-lg text-white me-2">Quản lý phim</li></a>
        <a href="/admin/users"><li class="p-4 px-7 bg-orange-600 hover:bg-orange-700 duration-200 hover:cursor-pointer w-44 text-center rounded-lg text-white me-2">Quản lý người dùng</li></a>
        <a href="/admin/comments"><li class="p-4 px-7 bg-orange-600 hover:bg-orange-700 duration-200 hover:cursor-pointer w-44 text-center rounded-lg text-white me-2">Quản lý bình luận</li></a>
    </ul>
</x-layout>
