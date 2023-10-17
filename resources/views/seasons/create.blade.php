<x-layout>
    <div class="bg-gray-100 max-w-5xl m-auto pb-3 rounded-lg">
        <h1 class="font-medium text-3xl pt-10 text-orange-600 text-center">Thêm season phim mới</h1>
        <form id="episode-form" action="/seasons/store" enctype="multipart/form-data" method="POST">
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
                <div id="ss-info">
                    <div id="ss-list">
                        @foreach ($series as $seri)
                            @unless ($seri->seasons->count() == 0)
                                <div hidden id="seri-{{ $seri->sr_id }}-seasons">
                                    <span class="ms-1 text-gray-400">Các seasons phim đã đăng: </span>
                                    @foreach ($seri->seasons->sortBy('ss_release_date') as $season)
                                        <span class='inline-block mt-2 bg-gray-200 text-gray-400 rounded-lg p-3 mx-1 px-4'>
                                            {{ $season->ss_tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endunless
                        @endforeach
                    </div>
                    <div class="my-6">
                        <label for="ss_name" class="inline-block ps-1">Tên season phim: <span class="text-red-500">*</span></label>
                        <input id="ss_name" autocomplete="off" type="text"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ss_name"
                            value="{{ old('ss_name') }}" />

                        @error('ss_name')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="ss_tag" class="inline-block ps-1">Tag <span class="text-xs italic">(Phần 1, Phần 2, Movie 1,...)</span>: <span class="text-red-500">*</span></label>
                        <input id="ss_tag" autocomplete="off" type="text"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ss_tag"
                            value="{{ old('ss_tag') }}" />

                        @error('ss_tag')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="ss_release_date" class="inline-block ps-1">Ngày ra mắt:</label>
                        <input id="ss_release_date" autocomplete="off" type="date"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ss_release_date"
                            value="{{ old('ss_release_date') }}" />

                        @error('ss_release_date')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="ss_director" class="inline-block ps-1">Đạo diễn:</label>
                        <input id="ss_director" autocomplete="off" type="text"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ss_director"
                            value="{{ old('ss_director') }}" />

                        @error('ss_director')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="ss_categories" class="inline-block ps-1">Thể loại: <span class="text-red-500">*</span></label>
                        <input id="ss_categories" autocomplete="off" type="text"
                            class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="ss_categories"
                            value="{{ old('ss_categories') }}" />

                        @error('ss_categories')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="ss_single" class="inline-block ps-1">Là phim lẻ?</label>
                        <input id="ss_single" autocomplete="off" type="checkbox"
                            class="rounded-lg ms-3 p-3 leading-none w-5 h-5  border-gray-50" name="ss_single"
                            @if (old('ss_single'))
                                {{ 'checked' }}
                            @endif  />
                    </div>
                    <div class="mb-6">
                        <label for="ss_description" class="inline-block ps-1">Mô tả season: <span class="text-red-500">*</span></label>
                        <textarea id="ss_description" autocomplete="off" rows="5"
                            class="border rounded-lg p-3 w-full outline-gray-500" name="ss_description"
                            >{{ old('ss_description') }}</textarea>

                        @error('ss_description')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="inline-block ps-1">Poster: <span class="text-red-500">*</span></label>
                        <p class="ps-1 my-1 text-gray-400 truncate" id="selected-file1">Chưa có hình ảnh được chọn</p>
                        <img class="hidden rounded-lg mb-2 h-56" src=""
                            id="image-preview1"/>
                        <label for="ss_poster"
                            class="border block w-fit rounded-lg p-3 leading-none h-10 bg-white outline-gray-500 cursor-pointer hover:text-white hover:bg-orange-600 duration-150">Upload
                            ảnh</label>
                        <input id="ss_poster" autocomplete="off" hidden accept="image/*" type="file"
                            class=" border rounded-lg p-3 w-full h-10 outline-gray-500" name="ss_poster"
                            value="{{ old('ss_poster') }}" />
                        @error('ss_poster')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="inline-block ps-1">Ảnh bìa: <span class="text-red-500">*</span></label>
                        <p class="ps-1 my-1 text-gray-400 truncate" id="selected-file2">Chưa có hình ảnh được chọn</p>
                        <img class="hidden rounded-lg mb-2 h-56" src=""
                            id="image-preview2"/>
                        <label for="ss_bg"
                            class="border block w-fit rounded-lg p-3 leading-none h-10 bg-white outline-gray-500 cursor-pointer hover:text-white hover:bg-orange-600 duration-150">Upload
                            ảnh</label>
                        <input id="ss_bg" autocomplete="off" hidden accept="image/*" type="file"
                            class=" border rounded-lg p-3 w-full h-10 outline-gray-500" name="ss_bg"
                            value="{{ old('ss_bg') }}" />
                        @error('ss_bg')
                            <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <center class="mb-6">
                        <button type="submit"
                            class="bg-orange-600 text-white rounded-lg py-2 px-4 duration-100 ease-linear hover:bg-orange-700">Thêm
                            season phim mới</button>
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
                $(`#seri-${seriId}-seasons`).attr('hidden', false).siblings().attr('hidden', true);
            }
        }


        $('#series').on('loaded.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            if ($('#old_sr').val()) {
                $(this).selectpicker('val', $('#old_sr').val());
            }
            updateSeasonList($(this).val());
        });

        $('#series').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            updateSeasonList($(this).val());
        });

        $("#ss_poster").change((e) => {
            $("#selected-file1").text(e.target.files[0].name);
            imageURL = URL.createObjectURL(e.target.files[0]);
            $("#image-preview1").prop('src', imageURL).show();
        })

        $("#ss_bg").change((e) => {
            $("#selected-file2").text(e.target.files[0].name);
            imageURL = URL.createObjectURL(e.target.files[0]);
            $("#image-preview2").prop('src', imageURL).show();
        })
    </script>
</x-layout>
