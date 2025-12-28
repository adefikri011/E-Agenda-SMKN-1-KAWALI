<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('image/logoo.png') }}">

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


        /* ========================================================= */
        /*  GAYA DASAR UNTUK SEMUA ELEMEN FORM (INPUT, SELECT, DLL)  */
        /* ========================================================= */

        .form-control {
            /* Layout & Ukuran */
            width: 100%;
            /* Buat elemen mengisi lebar kontainer */
            height: 46px;
            /* Tinggi yang sama untuk semua elemen */
            padding: 0 16px;
            /* Padding horizontal yang lega */

            /* Warna & Border */
            border: 1px solid #e5e7eb;
            /* Border yang soft dan modern */
            border-radius: 0.75rem;
            /* Sudut yang membulat */
            background-color: #ffffff;

            /* Tipografi */
            font-size: 0.95rem;
            color: #374151;

            /* Efek Modern */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            /* Shadow halus */
            transition: all 0.2s ease-in-out;
            /* Transisi halus untuk semua perubahan */
        }

        /* Hapus outline default dan ganti dengan bayangan saat fokus */
        .form-control:focus {
            outline: none;
            /* Penting! */
            border-color: #3b82f6;
            /* Border biru saat fokus */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            /* Ring biru saat fokus */
        }

        /* Khusus untuk textarea, biarkan tingginya bisa diatur */
        textarea.form-control {
            height: auto;
            padding-top: 12px;
            padding-bottom: 12px;
            line-height: 1.5;
        }


        /* ========================================================= */
        /*            PENYESUAIAN KHUSUS UNTUK SELECT2               */
        /*    (Agau Select2 mengikuti gaya .form-control di atas)    */
        /* ========================================================= */

        /* 1. Buat kontainer Select2 mengikuti gaya .form-control */
        .select2-container--default .select2-selection--single {
            /* Turunkan semua properti dari .form-control */
            height: 46px !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            padding: 0 16px !important;
            background-color: #ffffff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease-in-out !important;
        }

        /* 2. Teks yang dipilih di dalam Select2 */
        .select2-selection__rendered {
            line-height: 44px !important;
            /* Sesuaikan dengan tinggi total */
            padding-left: 0 !important;
            color: #374151;
            font-size: 0.95rem;
        }

        /* 3. Panah dropdown Select2 */
        .select2-selection__arrow {
            height: 46px !important;
            right: 12px !important;
            width: 20px !important;
        }

        .select2-selection__arrow b {
            border-color: #9ca3af transparent transparent transparent;
        }

        /* 4. Efek Focus dan Hover untuk Select2 (sama dengan .form-control) */
        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #3b82f6 !important;
            outline: 0 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        .select2-container:hover .select2-selection--single {
            border-color: #d1d5db !important;
        }

        .select2-dropdown {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            background-color: #ffffff;
            margin-top: 4px;
        }

        .select2-results__option {
            padding: 12px 16px;
            color: #374151;
            transition: background-color 0.15s ease-in-out;
        }

        .select2-results__option--highlighted {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
        }

        .select2-results__option[aria-selected="true"] {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
            font-weight: 500;
        }
    </style>

    <!-- SCRIPT UNTUK MENGHILANGKAN SKELETON -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Global Reusable Select2 Initialization Pattern
        // Safely initialize Select2 on any element with .select2 class
        window.initSelect2 = function(selector) {
            $(selector).each(function() {
                let $select = $(this);

                // Destroy existing Select2 instance if it exists
                if ($select.data('select2')) {
                    $select.select2('destroy');
                }

                // Find modal parent if exists
                let modalParent = $select.closest('.modal');

                // Initialize Select2
                $select.select2({
                    placeholder: $select.data('placeholder') || 'Pilih Data',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: modalParent.length ? modalParent : $('body')
                });
            });
        };

        $(document).ready(function() {
            // Initialize all existing .select2 elements on page load
            window.initSelect2('.select2');

            // Event listener untuk file upload
            // Event listener untuk file upload (guard jika elemen tidak ada)
            const fileUploadEl = document.getElementById('file-upload');
            if (fileUploadEl) {
                fileUploadEl.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name;
                    const fileNameDiv = document.getElementById('file-name');

                    if (fileNameDiv) {
                        if (fileName) {
                            fileNameDiv.textContent = fileName;
                            fileNameDiv.classList.remove('hidden');
                        } else {
                            fileNameDiv.classList.add('hidden');
                        }
                    }
                });
            }

            // Event listener untuk menutup modal
            document.querySelectorAll('.modal-close').forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modal = this.closest('.modal');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                });
            });
        });
    </script>


</body>

</html>
