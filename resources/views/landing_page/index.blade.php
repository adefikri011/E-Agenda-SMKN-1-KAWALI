<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-Agenda Kelas - Platform Digital untuk Agenda Kelas</title>


    <link rel="icon" type="image/png" href="{{ asset('image/logoo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Konfigurasi Tailwind manual tambahan -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    //Tambahan warna custom agar konsisten
                    colors: {
                        primary: '#3498db',
                        secondary: '#2980b9',
                        accent: '#e3f2fd',
                        dark: '#2c3e50',
                        light: '#ecf0f1',
                    },

                    //Mengganti font default menjadi Inter
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            position: relative;
            padding-bottom: 4px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: #2563eb;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }


        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
            border-color: rgba(59, 130, 246, 0.3);
        }

        /* Mockup / preview dashboard */
        .dashboard-preview {
            background: linear-gradient(to bottom, #f8fafc, #e2e8f0);
            border-radius: 12px;
            padding: 24px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
        }

        /* Progress bar*/
        .progress-fill {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            height: 100%;
            border-radius: 3px;
        }
    </style>
</head>

<body class="font-sans text-gray-900 overflow-x-hidden bg-white">

    @include('landing_page.layout.navbar')
    @include('landing_page.layout.hero')

    <!-- Bagian lain masih dimatikan dulu -->
    @include('landing_page.layout.fitur')
    @include('landing_page.layout.benefits')
    @include('landing_page.layout.team')
    @include('landing_page.layout.testimoni')
    @include('landing_page.layout.footer')


    <script>
        //MENU MOBILE
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden'); // Buka/tutup menu mobile
        });

        //efek scoll di navbar
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');

            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg', 'py-2'); // Saat scroll: kecil + shadow
                navbar.classList.remove('py-4');
            } else {
                navbar.classList.remove('shadow-lg', 'py-2'); // Kembali normal
                navbar.classList.add('py-4');
            }
        });

        //SMOOTH SCROLL UNTUK LINK NAVBAR
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));

                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                // Tutup menu mobile kalau sedang terbuka
                mobileMenu.classList.add('hidden');
            });
        });

        //ANIMASI MUNCUL UNTUK CARD
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.card-hover').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>

</html>
