@props(['seasons_by_view'])
{{-- FLowbite --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>


<div id="default-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="7000">
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
        @foreach ($seasons_by_view->take(5) as $item)
            <div class="hidden duration-700 ease-in-out carousel-blur-card" data-carousel-item>
                <div class="w-full h-full">
                    <img src="{{ $item[0]->season->ss_bg ? asset('storage/' . $item[0]->season->ss_bg) : asset('images/no-thumbnail.jpg') }}"
                        class="absolute block w-full h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                        alt="...">
                </div>
                <div class="-translate-y-56 translate-x-24 p-2 bg-white/30 backdrop-blur-lg flex w-fit rounded-lg">
                    <img class="h-40 inline-block me-5"
                        src="{{ $item[0]->season->ss_poster ? asset('storage/' . $item[0]->season->ss_poster) : asset('images/no-thumbnail.jpg') }}"
                        alt="">
                    <div class="flex flex-col justify-between mt-3 text-white drop-shadow pe-3">
                        <div>
                            <p class="text-xl uppercase font-bold max-w-xs">{{ $item[0]->season->ss_name }}</p>
                            <p class="">{{ $item[0]->season->ss_categories }}</p>
                            <p class="text-xs font-light">{{ $item['total_views'] }} lượt xem</p>
                        </div>
                        <a class="bg-white text-orange-600 py-3 mb-3 ps-16 pe-7 rounded-lg block mt-5 relative w-fit"
                            href="/seasons/{{ $item[0]->season->ss_id }}">
                            <i
                                class="fa-solid fa-circle-play pe-4 text-3xl absolute top-1/2 transform -translate-y-1/2 left-3"></i>
                            Xem ngay
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Slider indicators -->
    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
        @foreach ($seasons_by_view->take(5) as $item)
            @if ($loop->first)
                <button type="button" class="w-5 h-1 rounded-3xl backdrop-blur-lg" aria-current="true"
                    aria-label="Slide {{ $loop->index + 1 }}" data-carousel-slide-to="{{ $loop->index + 1 }}"></button>
            @else
                <button type="button" class="w-5 h-1 rounded-3xl backdrop-blur-lg" aria-current="false"
                    aria-label="Slide {{ $loop->index + 1 }}" data-carousel-slide-to="{{ $loop->index + 1 }}"></button>
            @endif
        @endforeach
    </div>
    <!-- Slider controls -->
    <button type="button"
        class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 backdrop-blur-lg dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button"
        class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 backdrop-blur-lg dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

<script>
    setInterval(() => {
        $('.carousel-blur-card').each((index, element) => {
            if ($(element).hasClass('z-20'))
                setTimeout(() => {
                    $(element).children('div').last().fadeIn(500).css('display', 'flex');
                }, 500);
            else
                $(element).children('div').last().fadeOut(500);
        });
    }, 100);
</script>
