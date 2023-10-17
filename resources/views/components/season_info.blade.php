@props(['season'])

<div class="rounded-lg bg-gray-100 flex items-center border-2 border-gray-200 overflow-hidden">
    <img class="mx-5 h-96 rounded-lg object-cover"
        src="{{ $season->ss_poster ? asset('storage/' . $season->ss_poster) : asset('images/poster_preview.jpg') }}"
        alt="">
    <div class="p-6 flex-grow">
        <h1 class="font-semibold text-3xl text-orange-600 pb-4">{{ $season->ss_name }}</h1>
        <p class="text-gray-500 h-44 overflow-y-auto text-justify pe-3">{!! nl2br($season->ss_description) !!}</p>
        <p class="mt-2"><span class="font-bold">Thể loại:</span> {{ $season->ss_categories ?? 'Chưa cập nhật' }}</p>
        <p><span class="font-bold">Quốc gia:</span> {{ $season->seri->sr_country }}</p>
        <p><span class="font-bold">Đạo diễn:</span> {{ $season->ss_director ?? 'Chưa cập nhật' }}</p>
        <p><span class="font-bold">Ngày ra mắt:</span> {{ date('d-m-Y', strtotime($season->ss_release_date)) ?? 'Chưa cập nhật' }}</p>
        <a class="bg-orange-600 text-white py-3 ps-16 pe-8 rounded-lg inline-block mt-5 relative" href="{{ $season->episodes->count() != 0 ? '/episodes/' . $season->episodes[0]->ep_id : '#' }}"
        >
            <i class="fa-solid fa-circle-play pe-4 text-3xl absolute top-1/2 transform -translate-y-1/2 left-3"></i>
            Xem phim
        </a>
    </div>
</div>
