<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShareTable') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cities.js'])

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>

        .custom-logo {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .swiper-container {
            width: 50%;
            height: 100%;
            overflow: hidden;
            border: solid 2px #991A14;
            border-radius: 10px;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-pagination-bullet {
            background: #0056b3; /* Color of inactive bullets */
        }

        .swiper-pagination-bullet-active {
            background: #991A14; /* Color of the active bullet */
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #991A14;
            width: 40px;
            height: 40px;
            font-weight: bolder;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px; /* Ajustez cette valeur si nécessaire */
        }

    </style>
</head>
<body class="font-sans antialiased bg-gray-200">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
</body>
</html>
