<x-layout>
    <div class="bg-gray-100 max-w-5xl m-auto pb-3 rounded-lg">
        <h1 class="font-medium text-3xl pt-10 text-orange-600 text-center">Cập nhật seri phim</h1>
        <form id="episode-form" action="/series/update/{{ $this_sr->sr_id }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="max-w-lg m-auto">
                <div class="my-6">
                    <label for="sr_name" class="inline-block ps-1">Tên seri phim:</label>
                    <input id="sr_name" autocomplete="off" type="text"
                        class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="sr_name"
                        value="{{ old('sr_name') ?? $this_sr->sr_name }}" />

                    @error('sr_name')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="sr_country" class="inline-block ps-1">Quốc gia:</label>
                    <input id="sr_country" autocomplete="off" type="text"
                        class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="sr_country"
                        value="{{ old('sr_country') ?? $this_sr->sr_country }}" />

                    @error('sr_country')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="inline-block ps-1">Poster:</label>
                    <p class="ps-1 my-1 text-gray-400 truncate" id="selected-file1">Poster hiện tại</p>
                    <img class="rounded-lg mb-2 h-56" src="{{ asset('storage/' . $this_sr->sr_poster )}}" id="image-preview1" />
                    <label for="sr_poster"
                        class="border block w-fit rounded-lg p-3 leading-none h-10 bg-white outline-gray-500 cursor-pointer hover:text-white hover:bg-orange-600 duration-150">Upload
                        ảnh</label>
                    <input id="sr_poster" autocomplete="off" hidden accept="image/*" type="file"
                        class=" border rounded-lg p-3 w-full h-10 outline-gray-500" name="sr_poster"
                        value="{{ old('sr_poster') }}" />
                    @error('sr_poster')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <center class="mb-6">
                    <button type="submit"
                        class="bg-orange-600 text-white rounded-lg py-2 px-4 duration-100 ease-linear hover:bg-orange-700">Cập nhật
                        seri phim</button>
                </center>
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
        $("#sr_poster").change((e) => {
            $("#selected-file1").text(e.target.files[0].name);
            imageURL = URL.createObjectURL(e.target.files[0]);
            $("#image-preview1").prop('src', imageURL).show();
        })
    </script>
</x-layout>
