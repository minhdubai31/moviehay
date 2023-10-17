<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-16">
        <header class="text-center text-orange-600 pt-2">
            <h2 class="text-2xl font-bold uppercase">Đăng nhập</h2>
            <p class="mb-4 text-xs">Đăng nhập để tận hưởng toàn bộ dịch vụ</p>
        </header>

        <form method="POST" action="/users/authenticate">
            @csrf

            <div class="mb-6">
                <label for="email" class="inline-block ps-1">Email:</label>
                <input id="email" autocomplete="off" type="email" class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="email"
                    value="{{ old('email') }}" />

                @error('email')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block ps-1">
                    Mật khẩu:
                </label>
                <input id="password" autocomplete="off" type="password" class="border rounded-lg p-3 w-full h-10 outline-gray-500" name="password"
                    value="{{ old('password') }}" />

                @error('password')
                    <p class="ms-1 text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-orange-600 text-white rounded-lg py-2 px-4 duration-100 ease-linear hover:bg-orange-700">
                    Đăng nhập
                </button>
            </div>

            <div class="mt-8">
                <p>
                    Bạn chưa có tài khoản?
                    <a href="/users/register" class="text-blue-600">Đăng ký</a>
                </p>
            </div>
        </form>
    </x-card>
</x-layout>
