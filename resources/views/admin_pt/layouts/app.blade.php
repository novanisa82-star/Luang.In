<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- Leaflet Map CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <!-- AOS (Animate On Scroll) Library CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "background": "#fcf9f8",
                        "surface": "#fcf9f8",
                        "surface-container-low": "#f6f3f2",
                        "surface-container": "#f0eded",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#630ed4",
                        "primary-container": "#7c3aed",
                        "on-primary": "#ffffff",
                        "secondary": "#5f5d6b",
                        "secondary-fixed": "#e5e0f1",
                        "on-surface": "#1b1b1c",
                        "tertiary": "#005c26",
                        "tertiary-fixed-dim": "#4ae176"
                    },
                    fontFamily: {
                        body: ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        };
    </script>
    <style>
        .card-hover-effect {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-hover-effect:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -6px rgba(99, 14, 212, 0.08), 0 4px 8px -4px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-[#fcf9f8] font-body text-gray-800 antialiased min-h-screen">

    <!-- Memanggil Sidebar -->
    @include('admin_pt.layouts.sidebar')

    <div class="pl-[260px]">
        <!-- Memanggil Header -->
        @include('admin_pt.layouts.header')

        <!-- Tempat Konten Berubah-ubah dengan AOS Animation -->
        <main class="w-full pt-16 bg-[#fcf9f8] min-h-[calc(100vh-64px)]" data-aos="fade-up" data-aos-duration="600">
            @yield('content')
        </main>
    </div>

    <!-- AOS (Animate On Scroll) JS CDN & Initialization -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            AOS.init({
                duration: 700,
                easing: 'ease-out-cubic',
                once: true,
                offset: 30
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
