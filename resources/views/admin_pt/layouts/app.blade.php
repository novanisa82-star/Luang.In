`<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=plusJakartaSans:wght@100..900&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config={darkMode:"class",theme:{extend:{colors:{"background":"#fcf9f8","surface":"#fcf9f8","surface-container-low":"#f6f3f2","surface-container":"#f0eded","surface-container-lowest":"#ffffff","primary":"#630ed4","primary-container":"#7c3aed","on-primary":"#ffffff","secondary":"#5f5d6b","secondary-fixed":"#e5e0f1","on-surface":"#1b1b1c","tertiary":"#005c26","tertiary-fixed-dim":"#4ae176"},fontFamily:{body:["plusJakartaSans"]}}}};</script>
</head>
<body class="bg-surface font-body text-on-surface antialiased min-h-screen">
    
    <!-- Memanggil Sidebar -->
    @include('admin_pt.layouts.sidebar')

    <div class="pl-[260px]">
        <!-- Memanggil Header -->
        @include('admin_pt.layouts.header')

        <!-- Tempat Konten Berubah-ubah -->
        <main class="w-full pt-16 bg-surface">
            @yield('content')
        </main>
    </div>
</body>
</html>