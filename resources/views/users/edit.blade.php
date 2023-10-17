<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-16">
        <header class="text-center text-orange-600 pt-2">
            <h2 class="text-2xl font-bold uppercase">Cập nhật tài khoản</h2>
        </header>

        <form method="POST" action="/users/update/{{ $this_user->user_id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="my-6 flex flex-col items-center">
                <img class="rounded-full border-2 border-gray-400 w-36 mb-2 h-36 object-cover"
                    src="{{ $this_user->avatar ? asset('storage/' . $this_user->avatar) : asset('images/default_avatar.png') }}"
                    id="image-preview1" />
                <label for="avatar"
                    class="block w-fit leading-none text-gray-500 cursor-pointer hover:text-gray-800 duration-150">Thay
                    đổi
                    ảnh đại diện</label>
                <input id="avatar" autocomplete="off" hidden accept="image/*" type="file"
                    class=" border rounded-lg p-3 w-full h-10 outline-gray-500" name="avatar" />
            </div>
            <div class="mb-6">
                <label for="name" class="inline-block ps-1">Tên người dùng: <span
                        class="text-red-500">*</span></label>
                <input id="name" autocomplete="off" type="text"
                    class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="username"
                    value="{{ old('username') ?? $this_user->username }}" />

                @error('username')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block ps-1">Email: <span class="text-red-500">*</span></label>
                <input id="email" autocomplete="off" type="email"
                    class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="email"
                    value="{{ old('email') ?? $this_user->email }}" />

                @error('email')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="change-pass" class="ps-1">Đổi mật khẩu?</label>
                <input type="checkbox" class="rounded-lg ms-3 p-3 leading-none w-5 h-5  border-gray-50"
                    name="change-pass" id="change-pass" @if (old('change-pass')) {{ 'checked' }} @endif>
            </div>
            <div id="change-pass-box" class="hidden">
                <div class="mb-6">
                    <label for="old_password" class="inline-block ps-1">
                        Mật khẩu cũ: <span class="text-red-500">*</span>
                    </label>
                    <input id="old_password" autocomplete="off" type="password"
                        class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="old_password"
                        value="" />
    
                    @error('old_password')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password" class="inline-block ps-1">
                        Mật khẩu mới: <span class="text-red-500">*</span>
                    </label>
                    <input id="password" autocomplete="off" type="password"
                        class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="password"
                        value="" />
    
                    @error('password')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="mb-6">
                    <label for="password2" class="inline-block ps-1">
                        Nhập lại mật khẩu mới: <span class="text-red-500">*</span>
                    </label>
                    <input id="password2" autocomplete="off" type="password"
                        class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="password_confirmation"
                        value="" />
    
                    @error('password_confirmation')
                        <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-6 text-center">
                <button type="submit"
                    class="bg-green-600 text-white rounded-lg py-2 px-4 duration-100 ease-linear hover:bg-green-800">
                    Cập nhật
                </button>
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

    function toggleChangePassBox() {
        $('#change-pass').prop('checked') ? $('#change-pass-box').show() : $('#change-pass-box').hide();
    }

    toggleChangePassBox();
    $('#change-pass').change(() => toggleChangePassBox());
    
</script>
