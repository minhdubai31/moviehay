<x-layout>
    <div class="bg-gray-100 max-w-5xl m-auto pb-3 rounded-lg">
        <h1 class="font-medium text-3xl pt-10 text-orange-600 text-center">Thêm tập phim mới</h1>
        <form id="episode-form" action="/episodes/store" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="max-w-lg m-auto">
                <div class="my-6">
                    <input type="hidden" id="old_sr" value="{{ old('sr_id') }}"></input>
                    <label for="series" class="ms-1">Series phim: <span class="text-red-500">*</span></label>
                    <select name="sr_id" id="series" class="bootstrap-iso selectpicker relative"
                        data-live-search="true" title="Vui lòng chọn seri phim">
                        @foreach ($series as $seri)
                            <option value="{{ $seri->sr_id }}">{{ $seri->sr_name }}</option>
                        @endforeach
                    </select>
                    @error('sr_id')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="my-6">
                    <input type="hidden" id="old_ss" value="{{ old('ss_id') }}"></input>
                    <label for="seasons" class="ms-1">Season phim: <span class="text-red-500">*</span></label>
                    <select name="ss_id" id="seasons" class="bootstrap-iso selectpicker relative"
                        data-live-search="true" title="Vui lòng chọn seri phim trước">
                        <span hidden>{{ old('ss_id') }}</span>
                        @foreach ($series as $seri)
                            @foreach ($seri->seasons as $season)
                                <option hidden class="seri-{{ $seri->sr_id }}-seasons" value="{{ $season->ss_id }}">
                                    {{ $season->ss_name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('ss_id')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div id="ep-info">
                    <div id="ep-list">
                        @foreach ($series as $seri)
                            @foreach ($seri->seasons as $season)
                                @unless ($season->episodes->count() == 0)
                                    <div hidden id="season-{{ $season->ss_id }}-episodes">
                                        <span class="ms-1 text-gray-400">Các tập phim đã đăng: </span>
                                        @foreach ($season->episodes as $episode)
                                            <span class='inline-block mt-2 bg-gray-200 text-gray-400 rounded-lg p-3 mx-1 px-4'>
                                                {{ $episode->ep_order }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endunless
                            @endforeach
                        @endforeach

                    </div>
                    <div class="my-6">
                        <label for="ep_name" class="inline-block ps-1">Tên tập phim:</label>
                        <input id="ep_name" autocomplete="off" type="text"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ep_name"
                            value="{{ old('ep_name') }}" />

                        @error('ep_name')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="ep_order" class="inline-block ps-1">Thứ tự tập: <span class="text-red-500">*</span></label>
                        <input id="ep_order" autocomplete="off" type="number" step="0.1"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ep_order"
                            value="{{ old('ep_order') }}" />

                        @error('ep_order')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="inline-block ps-1">Video: <span class="text-red-500">*</span></label>
                        <p class="ps-1 my-1 text-gray-400 truncate" id="selected-file">Chưa có video được chọn</p>
                        <video controls class="hidden rounded-lg mb-2 h-56" src="" id="video-preview"></video>
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
                            class="bg-orange-600 text-white rounded-lg py-2 px-4 duration-100 ease-linear hover:bg-orange-700">Thêm
                            tập phim mới</button>
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
        // Update seasons list
        function updateSeasonList(seriId) {
            if (seriId) {
                $('#seasons').selectpicker('destroy').children().first().remove();
                $('#seasons').children().prop('hidden', true);
                $(`.seri-${seriId}-seasons`).attr('hidden', false);
                $('#seasons').prop('title', 'Vui lòng chọn season phim');
                $('#old_ss').val() ? $('#seasons').selectpicker('val', $('#old_ss').val()) : $('#seasons').selectpicker();
            }

            $('#seasons').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                if ($(this).val()) {
                    $(`#ep-list`).children().attr('hidden', true);
                    $(`#season-${$(this).val()}-episodes`).attr('hidden', false);
                }
            });

            $('#seasons').on('loaded.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                if ($(this).val()) {
                    $(`#ep-list`).children().attr('hidden', true);
                    $(`#season-${$(this).val()}-episodes`).attr('hidden', false);
                }
            });

        }


        $('#series').on('loaded.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            if ($('#old_sr').val()) {
                $(this).selectpicker('val', $('#old_sr').val());
            }
            updateSeasonList($(this).val());
            $('#old_ss').val('');
        });

        $('#series').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            updateSeasonList($(this).val());
            $('#ep-list').children().attr('hidden', true);
        });

        $("#v_origin").change((e) => {
            $("#selected-file").text(e.target.files[0].name);
            videoURL = URL.createObjectURL(e.target.files[0]);
            $("#video-preview").prop('src', videoURL).show();
        })
    </script>
</x-layout>
