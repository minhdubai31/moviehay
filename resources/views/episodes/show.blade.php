<x-layout>
    {{-- import plyr css config file --}}
    <link rel="stylesheet" href="{{ asset('css/video_control.css') }}">

    <div class="flex flex-wrap gap-5">
        <div class="lg:w-8/12 xl:w-9/12">
            <video class="vid1" autoplay controls="" crossorigin="" id="player" playsinline="">
                @if (file_exists('storage/' . $episode->v_origin))
                    <source size="{{ $episode->v_origin_size }}" src="{{ asset('storage/' . $episode->v_origin) }}"
                        type="video/mp4">
                    </source>
                @endif
                @isset($episode->v_sd)
                    @if (file_exists('storage/' . $episode->v_sd))
                        <source size="480" src="{{ asset('storage/' . $episode->v_sd) }}" type="video/mp4">
                        </source>
                    @endif
                @endisset
                @isset($episode->v_hd)
                    @if (file_exists('storage/' . $episode->v_hd))
                        <source size="720" src="{{ asset('storage/' . $episode->v_hd) }}" type="video/mp4">
                        </source>
                    @endif
                @endisset
            </video>
        </div>
        <div class="lg:hidden w-full">
            {{-- Episode info --}}
            <div class="flex justify-between gap-5">
                <div>
                    <p class="text-xl font-bold">
                        {{ $episode->season->ss_name }} - Tập {{ $episode->ep_order }} : {{ $episode->ep_name }}
                    </p>
                    <p>
                        {{ number_format($episode->views->count(), 0, '', '.') . ' lượt xem' }}
                    </p>
                </div>
                <div>
                    @auth
                        <form action="/likes" method="POST" onsubmit="handleLike(this, event);(event)">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                            <input type="hidden" name="ep_id" value="{{ $episode->ep_id }}">
                            <div class="bg-red-500 text-white rounded-full p-1.5 flex items-center">
                                <button type="submit"
                                    class="bg-red-400 rounded-full w-8 h-8 flex items-center justify-center">
                                    <i class="@if ($episode->likes->where('user_id', '=', auth()->user()->user_id)->count() == 0) fa-regular heart-icon
                            @else
                            fa-solid @endif fa-heart fa-beat-fade text-xl"></i>
                                </button>
                                <span class="total-likes ms-2 pe-3">
                                    {{ number_format($episode->likes->count(), 0, '', '.') }}
                                </span>
                            </div>
                        </form>
                    @else
                        <div class="bg-red-500 text-white rounded-full p-1.5 flex items-center">
                            <a href="/users/login">
                                <div class="bg-red-400 rounded-full w-8 h-8 flex items-center justify-center"
                                    title="Đăng nhập để yêu thích">
                                    <i class="fa-regular fa-heart text-xl"></i>
                                </div>
                            </a>
                            <span class="ms-2 pe-3">
                                {{ number_format($episode->likes->count(), 0, '', '.') }}
                            </span>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
        <div
            class="lg:grow border-2 border-gray-200 rounded-lg p-5 pe-4 relative flex flex-col w-full h-64 lg:w-auto lg:h-auto">
            <div class="w-full h-fit">
                <h1 class="font-bold pb-3">Danh sách tập</h1>
            </div>
            <div class="overflow-y-auto pe-4 relative grow">
                <div class="absolute">
                    <x-episodes_listing :episode="$episode" :thumb_width=36 :thumb_height=24 />
                </div>
            </div>
        </div>
      
    </div>
    <div class="lg:w-8/12 xl:w-9/12 mt-3">
        {{-- Episode info --}}
        <div class="justify-between gap-5 hidden lg:flex">
            <div>
                <p class="text-xl font-bold">
                    {{ $episode->season->ss_name }} - Tập {{ $episode->ep_order }} : {{ $episode->ep_name }}
                </p>
                <p>
                    {{ number_format($episode->views->count(), 0, '', '.') . ' lượt xem' }}
                </p>
            </div>
            <div>
                @auth
                    <form action="/likes" method="POST" onsubmit="handleLike(this, event);(event)">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                        <input type="hidden" name="ep_id" value="{{ $episode->ep_id }}">
                        <div class="bg-red-500 text-white rounded-full p-1.5 flex items-center hover:scale-110 duration-150">
                            <button type="submit" class="bg-red-400 rounded-full w-8 h-8 flex items-center justify-center hover:scale-110 duration-150">
                                <i class="@if ($episode->likes->where('user_id', '=', auth()->user()->user_id)->count() == 0) fa-regular
                                    @else
                                    fa-solid @endif fa-heart text-xl heart-icon hover:scale-125 duration-150 ease-out"></i>
                            </button>
                            <span class="total-likes ms-2 pe-3">
                                {{ number_format($episode->likes->count(), 0, '', '.') }}
                            </span>
                        </div>
                    </form>
                @else
                    <div class="bg-red-500 text-white rounded-full p-1.5 flex items-center hover:scale-110 duration-150">
                        <a href="/users/login">
                            <div class="bg-red-400 rounded-full w-8 h-8 flex items-center justify-center hover:scale-110 duration-150"
                                title="Đăng nhập để yêu thích">
                                <i class="fa-regular fa-heart text-xl hover:scale-110 duration-150 ease-out"></i>
                            </div>
                        </a>
                        <span class="ms-2 pe-3">
                            {{ number_format($episode->likes->count(), 0, '', '.') }}
                        </span>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Comments --}}
        <div class="border-2 border-gray-200 rounded-lg p-5 pb-3 mt-3">
            @auth
                <form id="comment-form" class="my-3" action="/comments" method="POST" onkeyup="commentAccept(this, true)"
                    onsubmit="storeComment(this, event);(event)">
                    @csrf
                    <div
                        class="p-2 bg-slate-100 rounded-2xl border-slate-200 border-2 box-content focus-within:bg-white duration-200 ease-linear">
                        <textarea
                            class="block p-4 bg-slate-100 duration-300 ease-linear rounded-2xl w-full border-none outline-0 focus:bg-white"
                            placeholder="Viết bình luận" name="cmt_content" id="cmt_content" cols="30" rows="2"></textarea>
                        </textarea>
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                    <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                    <input type="hidden" name="ep_id" value="{{ $episode->ep_id }}">
                    <button id="comment-button"
                        class="bg-slate-200 rounded-full mt-1.5 text-gray-400 p-2 px-4 duration-100 ease-linear"
                        name="submitBtn" disabled>
                        Bình luận
                    </button>
                    <span
                        class="ms-3 hidden bg-red-500 rounded-full mt-1.5 text-white p-2 px-4 ease-linear hover:cursor-pointer hover:bg-red-700"
                        onclick="removeCancelBtn(this.parentElement)">Hủy</span>
                </form>
            @else
                <form class="my-3" action="#">
                    <div class="p-2 bg-slate-200 rounded-2xl">
                        <textarea class="block p-4 bg-slate-200 placeholder-gray-400/50 rounded-2xl w-full border-none outline-0" disabled
                            placeholder="Vui lòng đăng nhập để có thể bình luận" name="" id="" cols="30"
                            rows="2"></textarea>
                        </textarea>
                    </div>
                    <button class="bg-slate-200 rounded-full mt-1.5 text-gray-400/50 p-2 px-4" disabled>
                        Bình luận
                    </button>
                </form>
            @endauth
            <hr class="border-gray-200 my-5">

            {{-- Comments list --}}
            <div id="comments-container">
            </div>
        </div>
    </div>

    {{-- Import plyr js config file --}}
    <script src="{{ asset('js/video_control.js') }}"></script>

    {{-- Submit comment --}}
    <script src="{{ asset('js/comments_client_handler.js') }}"></script>
    <script src="{{ asset('js/likes_client_handler.js') }}"></script>
    <script>
        updateComments({{ $episode->ep_id }});
    </script>
</x-layout>
