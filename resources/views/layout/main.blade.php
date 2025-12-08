<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('iamge/logoo.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- SCRIPT UNTUK MENGHILANGKAN SKELETON -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.getElementById("main-skeleton").classList.add("hidden");
                document.getElementById("main-content").classList.remove("hidden");
            }, 700); // durasi loading
        });
    </script>

</head>

<body class="bg-gray-50">

    <!-- ========================================================= -->
    <!-- SKELETON LOADING (NAVBAR + CONTENT) -->
    <!-- ========================================================= -->
    <div id="main-skeleton" class="animate-pulse">

        <!-- NAVBAR SKELETON -->
        <div class="w-full h-16 bg-white shadow-sm flex items-center px-6 gap-4">
            <div class="w-40 h-6 bg-gray-200 rounded"></div>
            <div class="w-28 h-6 bg-gray-200 rounded"></div>
            <div class="w-20 h-6 bg-gray-200 rounded"></div>

            <div class="ml-auto flex items-center gap-4">
                <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                <div class="w-24 h-6 bg-gray-200 rounded"></div>
            </div>
        </div>

        <!-- CONTENT SKELETON -->
        <div class="px-6 py-8">
            <div class="bg-white rounded-xl shadow p-8">
                <div class="w-56 h-8 bg-gray-200 rounded mb-6"></div>
                <div class="w-full h-64 bg-gray-200 rounded"></div>
            </div>
        </div>

    </div>

    <!-- ========================================================= -->
    <!-- KONTEN ASLI (DISSEMBUNYIKAN DULU) -->
    <!-- ========================================================= -->
    <div id="main-content" class="hidden">

        <!-- NAVBAR ASLI -->
        @include('layout.navbar')

        <x-notification />

        <!-- HALAMAN ASLI -->
        <div class="pt-24 pb-12 min-h-screen">
            <div class="container mx-auto px-4 lg:px-8">
                @yield('content')
            </div>
        </div>

    </div>

    @stack('script')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>
