<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tenwebsite</title>
    <script src="https://kit.fontawesome.com/fff06ecf43.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
</head>

<body class="max-w-5xl m-auto">
    <nav class="grid grid-cols-2 py-3">
        <div class="flex">
            <div class="website-logo flex items-center">
                <img class="object-contain" src="{{ asset('images/logo.png') }}" alt="Logo" srcset="">
            </div>
            <ul class="link-list flex ms-4 align-middle">
                <li class="px-4"><a class="leading-10 hover:font-semibold" href="">Trang chủ</a></li>
                <li class="px-4"><a class="leading-10 hover:font-semibold" href="">Phim</a></li>
                <li class="px-4"><a class="leading-10 hover:font-semibold" href="">Video</a></li>
            </ul>
        </div>
        <div class="col-start-2 flex justify-end items-center">
            @include('partials._search')
            <a class="ps-8" href="">
                <i class="fa-solid fa-user"></i>
                <span class="ps-1">Login</span>
            </a>
        </div>

    </nav>
    {{ $slot }}
</body>

</html>
