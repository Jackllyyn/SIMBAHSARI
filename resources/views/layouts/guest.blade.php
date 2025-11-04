{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMBAHSARI')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 
                        green: { 
                            50: '#f0fdf4', 100: '#dcfce7', 500: '#22c55e', 
                            600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d' 
                        } 
                    },
                    fontFamily: { 
                        sans: ['Inter', 'sans-serif'], 
                        display: ['"Space Grotesk"', 'sans-serif'] 
                    }
                }
            }
        }
    </script>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>

    <style>
        .navbar-link { @apply text-gray-700 hover:text-green-600 font-medium transition; }
        .navbar-link.active { @apply text-green-600 font-bold; }
        .logo-glow { filter: drop-shadow(0 0 8px rgba(34, 197, 94, 0.3)); }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-green-100 to-emerald-50 text-gray-900 font-sans min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-green-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- LOGO BESAR -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-green-600 to-emerald-700 
                                p-2 shadow-xl group-hover:scale-110 transition-all duration-300 logo-glow overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="SIMBAHSARI Logo" 
                             class="w-full h-full object-contain">
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-green-700 to-emerald-600 bg-clip-text text-transparent">
                            SIMBAHSARI
                        </h1>
                        <p class="text-xs font-medium text-green-600">Bank Sampah Digital</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="navbar-link {{ request()->is('/') ? 'active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('galeri') }}" class="navbar-link {{ request()->is('galeri') ? 'active' : '' }}">
                        Galeri
                    </a>
                    <a href="{{ route('articles.index') }}" class="navbar-link {{ request()->is('artikel*') ? 'active' : '' }}">
                        Artikel
                    </a>
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-2.5 px-6 rounded-full flex items-center gap-2 hover:shadow-lg transition-all">
                        Login
                    </a>
                </div>

                <!-- Mobile Menu -->
                <div x-data="{ open: false }" class="md:hidden">
                    <button @click="open = !open" class="p-2 rounded-lg hover:bg-green-50 transition">
                        <i data-lucide="menu" class="w-6 h-6 text-green-700"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition 
                         class="absolute top-full left-0 right-0 bg-white/95 backdrop-blur-md shadow-xl border-t border-green-100">
                        <div class="py-3 space-y-1 px-4">
                            <a href="{{ route('home') }}" class="block py-2.5 text-gray-700 hover:text-green-600 font-medium">Beranda</a>
                            <a href="{{ route('galeri') }}" class="block py-2.5 text-gray-700 hover:text-green-600 font-medium">Galeri</a>
                            <a href="{{ route('articles.index') }}" class="block py-2.5 text-gray-700 hover:text-green-600 font-medium">Artikel</a>
                            <a href="{{ route('login') }}" class="block py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg text-center font-medium">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="flex-1">@yield('content')</main>

    <!-- FOOTER DENGAN MAPS RESPONSIF -->
    <footer class="bg-gradient-to-t from-green-900 to-green-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Informasi -->
                <div class="text-center md:text-left space-y-4">
                    <div class="flex justify-center md:justify-start items-center gap-3">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm p-2">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">SIMBAHSARI</h3>
                            <p class="text-green-200 text-sm">Bank Sampah Digital</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-green-100">
                        <p><strong>Alamat:</strong> Desa Dukuhbangsa, Kec. Jatinegara, Kab. Tegal, Jawa Tengah</p>
                        <p><strong>Kontak:</strong> +62 812-3456-7890</p>
                        <p><strong>Email:</strong> simbahsari@gmail.com</p>
                    </div>
                    <p class="text-xs text-green-300 mt-6">
                        &copy; {{ date('Y') }} Instagram : @poetstar_
                    </p>
                </div>

                <!-- Google Maps Responsif -->
                <div class="w-full h-64 md:h-80 rounded-2xl overflow-hidden shadow-2xl border-4 border-white/20">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31677.80956043367!2d109.21890744751012!3d-7.041429597589405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fea63c43c08a9%3A0xc54dc06a1afe6141!2sDukuhbangsa%2C%20Kec.%20Jatinegara%2C%20Kabupaten%20Tegal%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1762175009509!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                </div>
            </div>
        </div>
    </footer>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({ once: true, duration: 800 });
            lucide.createIcons();
        });
    </script>
</body>
</html>