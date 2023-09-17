@props(['season'])

<div class="h-96 rounded-lg bg-gray-100 grid grid-cols-4">
    <img class="h-full max-w-full rounded-l-lg object-cover"
        src="{{ $season->season_poster ? asset('storage/' . $season->season_poster) : asset('images/no-thumbnail.jpg') }}"
        alt="">
    <div class="col-span-3 p-6 ps-10 grid-rows-6">
        <h1 class="font-semibold text-3xl text-orange-600 pb-4">Thanh guom diet quy</h1>
        <p class="text-gray-500 h-40 overflow-y-auto text-justify pe-3">Thanh gươm diệt quỷ phần 3, còn được biết đến với tên
            gọi "Làng thợ rèn", là phần tiếp theo của bộ anime đình đám cùng tên. Phần phim này tiếp tục theo chân
            Tanjiro và các bạn trong quá trình luyện tập và chiến đấu với các con quỷ. Trong phần này, Tanjiro sẽ
            đến làng thợ rèn để được làm lại thanh kiếm của mình, đồng thời gặp gỡ các thợ rèn và học hỏi thêm về
            cách sử dụng thanh kiếm.</p>
        <p class="mt-1"><span class="font-bold">Thể loại:</span> Fantasy, phiêu lưu, hành động, harem</p>
        <p><span class="font-bold">Quốc gia:</span> Nhật Bản</p>
        <div class="mt-5">
            <form action="#" method="GET">
                <button class="bg-orange-600 text-white py-3 ps-16 pe-8 rounded-xl relative" type="submit">
                    <i class="fa-solid fa-circle-play pe-4 text-3xl absolute top-1/2 transform -translate-y-1/2 left-3"></i>
                    Xem phim
                </button>
            </form>
        </div>

    </div>
</div>