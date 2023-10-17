<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-16">
        <header class="text-center text-orange-600 pt-2">
            <h2 class="text-2xl font-bold uppercase">Đăng ký</h2>
            <p class="mb-4 text-xs">Tạo tài khoản để tận hưởng toàn bộ dịch vụ</p>
        </header>

        <form method="POST" action="/users" enctype="multipart/form-data">
            @csrf
            <div class="my-6 flex flex-col items-center">
                <img class="rounded-full border-2 border-gray-400 w-36 mb-2 h-36 object-cover"
                    src="{{ asset('images/default_avatar.png') }}" id="image-preview1" />
                <label for="avatar"
                    class="block w-fit leading-none text-gray-500 cursor-pointer hover:text-gray-800 duration-150">Thêm
                    ảnh đại diện</label>
                <input id="avatar" autocomplete="off" hidden accept="image/*" type="file"
                    class=" border rounded-lg p-3 w-full h-10 outline-gray-500" name="avatar"
                    />
            </div>
            <div class="mb-6">
                <label for="name" class="inline-block ps-1">Tên người dùng: <span
                        class="text-red-500">*</span></label>
                <input id="name" autocomplete="off" type="text"
                    class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="username"
                    value="{{ old('username') }}" />

                @error('username')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block ps-1">Email: <span class="text-red-500">*</span></label>
                <input id="email" autocomplete="off" type="email"
                    class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="email"
                    value="{{ old('email') }}" />

                @error('email')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block ps-1">
                    Mật khẩu: <span class="text-red-500">*</span>
                </label>
                <input id="password" autocomplete="off" type="password"
                    class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="password"
                    value="{{ old('password') }}" />

                @error('password')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password2" class="inline-block ps-1">
                    Nhập lại mật khẩu: <span class="text-red-500">*</span>
                </label>
                <input id="password2" autocomplete="off" type="password"
                    class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="password_confirmation"
                    value="{{ old('password_confirmation') }}" />

                @error('password_confirmation')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit"
                    class="bg-orange-600 text-white rounded-lg py-2 px-4 duration-100 ease-linear hover:bg-orange-700">
                    Đăng ký
                </button>
            </div>

            <div class="mt-8">
                <p>
                    Bạn đã có tài khoản?
                    <a href="/users/login" class="text-blue-600">Đăng nhập</a>
                </p>
            </div>
        </form>
    </x-card>
</x-layout>
<script>
    $("#avatar").change((e) => {
        $("#selected-file1").text(e.target.files[0].name);
        imageURL = URL.createObjectURL(e.target.files[0]);
        $("#image-preview1").prop('src', imageURL).show();
    })
</script>
