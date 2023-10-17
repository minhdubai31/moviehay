@if ($episode->comments->isEmpty())
    <p class="text-center pb-2">Hãy là người đầu tiên để lại bình luận.</p>
@else
    @foreach ($episode->comments->reverse() as $comment)
        <div class="my-2">
            <div class="flex">
                <img class="h-10 w-10 me-2 rounded-full border border-gray-400 inline-block object-cover"
                src=" {{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : asset('images/default_avatar.png') }} "
                alt="">
                <div class="bg-slate-200 rounded-2xl p-4 px-5 inline-block" style="min-width: 10rem">
                    <p class="font-bold">{{ $comment->user->username }}</p>
                    <p>{!! nl2br($comment->cmt_content) !!}</p>
                </div>
            </div>
            <div class="text-xs font-medium text-gray-700 ms-14 mt-1">
                <span class="cmt_reply hover:cursor-pointer hover:text-black hover:font-bold"
                    onclick="showReplyBox(this)">Trả lời</span>
                @auth
                    @if ($comment->user->user_id == auth()->user()->user_id)
                        <form class="m-0 inline ms-4" action="/comments/delete/{{ $comment->cmt_id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="delete-btn p-1 text-xs text-red-500 rounded font-medium hover:font-bold hover:text-red-700">Xóa</button>
                        </form>
                    @endif
                @endauth
                <span class="cmt_duration ms-4 font-normal text-gray-400">{{ $comment->created_at }}</span>
            </div>
        </div>
        @auth
            <form id="replycomment-form" class="replycomment-form my-3 ms-20  hidden" action="/replycomments" method="POST"
                onkeyup="commentAccept(this);" onsubmit="storeComment(this, event);(event)">
                @csrf
                <div
                    class="p-2 bg-slate-100 rounded-2xl border-gray-200 border-2 box-content focus-within:bg-white duration-200 ease-linear">
                    <small class="ps-4 text-xm text-blue-600">Đang trả lời &#64;{{ $comment->user->username }}</small>
                    <textarea
                        class="block p-4 bg-slate-100 duration-300 ease-linear rounded-2xl w-full border-none outline-0 focus:bg-white"
                        placeholder="Viết bình luận" name="rcmt_content" id="cmt_content" cols="30" rows="2"></textarea>
                    </textarea>
                </div>
                <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                <input type="hidden" name="cmt_id" value="{{ $comment->cmt_id }}">
                <input type="hidden" name="rcmt_who" value="{{ $comment->user->user_id }}">
                <button id="comment-button"
                    class="bg-slate-200 rounded-full mt-1.5 text-gray-400 p-2 px-4 duration-100 ease-linear"
                    name="submitBtn" disabled>
                    Bình luận
                </button>
                <span
                    class="ms-3 bg-red-500 rounded-full mt-1.5 text-white p-2 px-4 ease-linear hover:cursor-pointer hover:bg-red-700"
                    onclick="clearForm(this.parentElement); $(this).parent().slideUp(200);">Hủy</span>
            </form>
        @else
            <form class="replycomment-form my-3 ms-20 hidden" action="#">
                <div class="p-2 bg-slate-200 rounded-2xl">
                    <textarea class="block p-4 bg-slate-200 placeholder-gray-400/50 rounded-2xl w-full border-none outline-0" disabled
                        placeholder="Vui lòng đăng nhập để có thể bình luận" name="" id="" cols="30" rows="2"></textarea>
                    </textarea>
                </div>
                <button class="bg-slate-200 rounded-full mt-1.5 text-gray-400/50 p-2 px-4" disabled>
                    Bình luận
                </button>
                <span
                    class="ms-3 bg-red-500 rounded-full mt-1.5 text-white p-2 px-4 ease-linear hover:cursor-pointer hover:bg-red-700"
                    onclick="$(this).parent().slideUp(200);">Hủy</span>
            </form>
        @endauth
        @foreach ($comment->replycomments as $replycomment)
            <div>
                <div class="my-2 ms-10">
                    <div class="flex">
                        <img class="h-8 w-8 me-2 rounded-full border border-gray-400 inline-block object-cover"
                        src=" {{ $replycomment->user->avatar ? asset('storage/' . $replycomment->user->avatar) : asset('images/default_avatar.png') }} "
                        alt="">
                        <div class="bg-slate-200 rounded-2xl p-4 px-5 inline-block" style="min-width: 10rem">
                            <p class="font-bold">{{ $replycomment->user->username }}</p>
                            <p><span class="text-blue-600">&#64;{{ $replycomment->replyUser->username }}
                                </span>{!! nl2br($replycomment->rcmt_content) !!}</p>
                        </div>
                    </div>
                    <div class="text-xs font-medium text-gray-700 ms-12 mt-1">
                        <span class="cmt_reply hover:cursor-pointer hover:text-black hover:font-bold"
                            onclick="showReplyBox(this)">
                            Trả lời
                        </span>
                        @auth
                            @if ($replycomment->user->user_id == auth()->user()->user_id)
                                <form class="m-0 inline ms-4" action="/replycomments/delete/{{ $replycomment->rcmt_id }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="delete-btn p-1 text-xs text-red-500 rounded font-medium hover:font-bold hover:text-red-700">Xóa</button>
                                </form>
                            @endif
                        @endauth
                        <span
                            class="cmt_duration ms-8 font-normal text-gray-400">{{ $replycomment->created_at }}</span>
                    </div>
                </div>
                @auth
                    <form id="replycomment-form" class="replycomment-form my-3 ms-28  hidden" action="/replycomments"
                        method="POST" onkeyup="commentAccept(this);" onsubmit="storeComment(this, event);(event)">
                        @csrf
                        <div
                            class="p-2 bg-slate-100 rounded-2xl border-gray-200 border-2 box-content focus-within:bg-white duration-200 ease-linear">
                            <small class="ps-4 text-xm text-blue-600">Đang trả lời
                                &#64;{{ $replycomment->user->username }}</small>
                            <textarea
                                class="block p-4 bg-slate-100 duration-300 ease-linear rounded-2xl w-full border-none outline-0 focus:bg-white"
                                placeholder="Viết bình luận" name="rcmt_content" id="cmt_content" cols="30" rows="2"></textarea>
                            </textarea>
                        </div>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                        <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                        <input type="hidden" name="cmt_id" value="{{ $comment->cmt_id }}">
                        <input type="hidden" name="rcmt_who" value="{{ $replycomment->user->user_id }}">
                        <button id="comment-button"
                            class="bg-slate-200 rounded-full mt-1.5 text-gray-400 p-2 px-4 duration-100 ease-linear"
                            name="submitBtn" disabled>
                            Bình luận
                        </button>
                        <span
                            class="ms-3 bg-red-500 rounded-full mt-1.5 text-white p-2 px-4 ease-linear hover:cursor-pointer hover:bg-red-700"
                            onclick="clearForm(this.parentElement); $(this).parent().slideUp(200);">Hủy</span>
                    </form>
                @else
                    <form class="replycomment-form my-3 ms-28 hidden" action="#">
                        <div class="p-2 bg-slate-200 rounded-2xl">
                            <textarea class="block p-4 bg-slate-200 placeholder-gray-400/50 rounded-2xl w-full border-none outline-0" disabled
                                placeholder="Vui lòng đăng nhập để có thể bình luận" name="" id="" cols="30"
                                rows="2"></textarea>
                            </textarea>
                        </div>
                        <button class="bg-slate-200 rounded-full mt-1.5 text-gray-400/50 p-2 px-4" disabled>
                            Bình luận
                        </button>
                        <span
                            class="ms-3 bg-red-500 rounded-full mt-1.5 text-white p-2 px-4 ease-linear hover:cursor-pointer hover:bg-red-700"
                            onclick="$(this).parent().slideUp(200);">Hủy</span>
                    </form>
                @endauth
            </div>
        @endforeach
    @endforeach
@endif
<script>
    $('.delete-btn').each((index, element) => {
        $(element).click((e) => {
            con = confirm('Bạn chắc chắn muốn xóa bình luận này?');
            if (con) {
                $(element).parent().submit();
            }
        })
    })
</script>
