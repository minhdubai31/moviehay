<x-layout>
    <div class="bg-gray-100 max-w-5xl m-auto pb-3 rounded-lg">
        <h1 class="font-medium text-3xl pt-10 text-orange-600 text-center">Cập nhật tập phim</h1>
        <form id="episode-form" action="/episodes/update/{{ $this_ep->ep_id }}" enctype="multipart/form-data"
            method="POST">
            @csrf
            @method('PUT')
            <div class="max-w-lg m-auto">
                <div class="my-6">
                    <label for="series" class="ms-1">Series phim: <span class="text-red-500">*</span></label>
                    <input type="text"
                        class="border rounded-lg p-3 w-full h-10 disabled:bg-gray-200 text-gray-400 outline-gray-500"
                        disabled value="{{ $this_ep->season->seri->sr_name }}"></input>
                </div>
                <div class="my-6">
                    <label for="seasons" class="ms-1">Season phim: <span class="text-red-500">*</span></label>
                    <input type="text"
                        class="border rounded-lg p-3 w-full h-10 disabled:bg-gray-200 text-gray-400 outline-gray-500"
                        disabled value="{{ $this_ep->season->ss_name }}"></input>
                </div>
                <div id="ep-info">
                    <div id="ep-list">
                        @unless ($this_ep->season->episodes->count() == 0)
                            <span class="ms-1 text-gray-400">Các tập phim đã đăng: </span>
                            @foreach ($this_ep->season->episodes as $episode)
                                <span
                                    class='inline-block mt-2 @if ($episode->ep_id == $this_ep->ep_id) {{ 'bg-orange-700/75 text-gray-100' }}
                                                @else
                                                    {{ 'bg-gray-200 text-gray-400' }} @endif  rounded-lg p-3 mx-1 px-4'>
                                    {{ $episode->ep_order }}
                                </span>
                            @endforeach
                        @endunless
                    </div>
                    <div class="my-6">
                        <label for="ep_name" class="inline-block ps-1">Tên tập phim:</label>
                        <input id="ep_name" autocomplete="off" type="text"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ep_name"
                            value="{{ old('ep_name') ?? $this_ep->ep_name }}" />
                        @error('ep_name')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="ep_order" class="inline-block ps-1">Thứ tự tập: <span
                                class="text-red-500">*</span></label>
                        <input id="ep_order" autocomplete="off" type="number" step="0.1"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ep_order"
                            value="{{ old('ep_order') ?? $this_ep->ep_order }}" />
                        @error('ep_order')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="inline-block ps-1">Video: <span class="text-red-500">*</span></label>
                        <p class="ps-1 my-1 text-gray-400 truncate" id="selected-file">Video hiện tại</p>
                        <video controls class="rounded-lg mb-2 h-56" src="{{ asset('storage/' . $this_ep->v_origin) }}"
                            id="video-preview"></video>
                        <label for="v_origin"
                            class="border block w-fit rounded-lg p-3 leading-none h-10 bg-white outline-gray-500 cursor-pointer hover:text-white hover:bg-orange-600 duration-150">Upload
                            video</label>
                        <input id="v_origin" autocomplete="off" hidden accept="video/*" type="file"
                            class=" border rounded-lg p-3 w-full h-10 outline-gray-500" name="v_origin"
                            value="{{ old('v_origin') }}" />
                        @error('v_origin')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <center class="mb-6">
                        <button type="submit"
                            class="bg-orange-600 text-white rounded-lg py-2 px-4 duration-100 ease-linear hover:bg-orange-700">Cập
                            nhật
                            tập phim</button>
                    </center>
                </div>
            </div>
        </form>
    </div>

    {{-- Select with search box --}}

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-iso.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <style>
        .dropdown {
            width: 100% !important;
            background-color: white;
            border-radius: .5rem;
            padding: .18rem .25rem;
            border: solid 1px #e5e7eb;
            display: block !important;
        }

        .dropdown-menu.show {
            -webkit-font-smoothing: subpixel-antialiased;
            -webkit-transform: translate(0) scale(1.0, 1.0);
        }

        .bootstrap-select .dropdown-toggle:focus {
            outline: none !important;
        }
    </style>
    <script>
        $("#v_origin").change((e) => {
            $("#selected-file").text(e.target.files[0].name);
            videoURL = URL.createObjectURL(e.target.files[0]);
            $("#video-preview").prop('src', videoURL).show();
        })
    </script>
</x-layout>
