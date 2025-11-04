<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMBAHSARI - Bank Sampah Digital</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script defer src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-emerald-50/90 via-teal-50/80 to-cyan-50/70 
               dark:from-gray-900 dark:via-gray-850 dark:to-slate-900 
               text-gray-800 dark:text-gray-100 font-sans antialiased"
      x-data="app()"
      :class="{ 'dark': $store.darkMode.enabled }"
      style="font-family: 'Inter', sans-serif;">

{{-- Alpine Logic --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('darkMode', {
            enabled: localStorage.getItem('darkMode') === 'true' || false,
            toggle() {
                this.enabled = !this.enabled;
                localStorage.setItem('darkMode', this.enabled);
            }
        });
    });

    function dropdown(section) {
        return {
            open: false,
            get isActive() {
                const path = window.location.pathname;
                if (section === 'nasabah') return path.includes('nasabah') || path.includes('setoran') || path.includes('penarikans');
                if (section === 'sampah') return path.includes('sampah') || path.includes('penjualan');
                return false;
            },
            init() { this.open = this.isActive; }
        }
    }

    function app() {
        return {
            sidebarOpen: window.innerWidth >= 1024,

            init() {
                this.$watch('$store.darkMode.enabled', value => {
                    document.documentElement.classList.toggle('dark', value);
                });

                // Responsif
                const handleResize = () => {
                    this.sidebarOpen = window.innerWidth >= 1024;
                };
                window.addEventListener('resize', handleResize);
                handleResize();

                // EDGE SWIPE: Geser dari kiri
                let touchStartX = 0;
                document.addEventListener('touchstart', (e) => {
                    if (window.innerWidth < 1024 && e.touches[0].clientX < 50) {
                        touchStartX = e.touches[0].clientX;
                    }
                }, { passive: true });

                document.addEventListener('touchmove', (e) => {
                    if (window.innerWidth < 1024 && touchStartX > 0) {
                        const diff = e.touches[0].clientX - touchStartX;
                        if (diff > 100) {
                            this.sidebarOpen = true;
                            touchStartX = 0;
                        }
                    }
                }, { passive: true });

                document.addEventListener('touchend', () => {
                    touchStartX = 0;
                }, { passive: true });
            },

            toggleSidebar() {
                if (window.innerWidth < 1024) {
                    this.sidebarOpen = !this.sidebarOpen;
                }
            },

            closeSidebar() {
                if (window.innerWidth < 1024) {
                    this.sidebarOpen = false;
                }
            }
        }
    }
</script>

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside x-cloak
           x-show="sidebarOpen"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-white/70 dark:bg-gray-900/80 backdrop-blur-xl 
                  border-r border-white/20 dark:border-gray-800/40 shadow-2xl 
                  lg:relative lg:translate-x-0 lg:shadow-xl flex flex-col">

        {{-- Logo + Tombol Tutup --}}
        <div class="p-4 sm:p-6 border-b border-white/20 dark:border-gray-800/40">
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 
                                flex items-center justify-center shadow-lg 
                                group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="SIMBAHSARI" class="w-full h-full object-contain p-1">
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-base sm:text-lg font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                            SIMBAHSARI
                        </h1>
                        <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Bank Sampah Digital</p>
                    </div>
                </a>

                <button @click="closeSidebar()"
                        class="lg:hidden p-2 rounded-xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl 
                               shadow-md hover:shadow-lg transition-all">
                    <i data-lucide="chevron-left" class="w-5 h-5 text-gray-700 dark:text-gray-300"></i>
                </button>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-3 sm:p-4 space-y-1 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-sm sm:text-base font-medium 
                      transition-all hover:bg-emerald-100/70 dark:hover:bg-emerald-900/40 
                      {{ Route::is('admin.dashboard') ? 'bg-emerald-100/80 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 shadow-md ring-1 ring-emerald-500/30' : 'text-gray-700 dark:text-gray-300' }}">
                <i data-lucide="layout-dashboard" class="w-4 sm:w-5 h-4 sm:h-5"></i>
                <span>Dashboard</span>
            </a>

            <!-- Dropdown: Nasabah -->
            <div x-data="dropdown('nasabah')">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-sm sm:text-base font-medium 
                               transition-all hover:bg-emerald-100/70 dark:hover:bg-emerald-900/40 
                               :class="{ 'bg-emerald-100/80 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 shadow-md ring-1 ring-emerald-500/30': open || isActive }"
                               class="text-gray-700 dark:text-gray-300">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <i data-lucide="users" class="w-4 sm:w-5 h-4 sm:h-5"></i>
                        <span>Nasabah</span>
                    </div>
                    <i :class="{ 'rotate-90': open }" data-lucide="chevron-right" class="w-3 sm:w-4 h-3 sm:h-4 transition-transform"></i>
                </button>

                <div x-show="open" x-collapse class="mt-1 space-y-1 pl-4 sm:pl-6">
                    <a href="{{ route('admin.nasabah.index') }}"
                       class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 
                              hover:bg-gray-100/60 dark:hover:bg-gray-800/50 rounded-lg transition-all">
                        <i data-lucide="list" class="w-3 sm:w-4 h-3 sm:h-4"></i>
                        <span>Daftar Nasabah</span>
                    </a>
                    <a href="{{ route('admin.setoran_sampah.index') }}"
                       class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 
                              hover:bg-gray-100/60 dark:hover:bg-gray-800/50 rounded-lg transition-all">
                        <i data-lucide="arrow-down-to-line" class="w-3 sm:w-4 h-3 sm:h-4"></i>
                        <span>Setoran Sampah</span>
                    </a>
                    <a href="{{ route('admin.penarikans.index') }}"
                       class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 
                              hover:bg-gray-100/60 dark:hover:bg-gray-800/50 rounded-lg transition-all">
                        <i data-lucide="arrow-up-from-line" class="w-3 sm:w-4 h-3 sm:h-4"></i>
                        <span>Penarikan Saldo</span>
                    </a>
                </div>
            </div>

            <!-- Dropdown: Sampah -->
            <div x-data="dropdown('sampah')">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-sm sm:text-base font-medium 
                               transition-all hover:bg-emerald-100/70 dark:hover:bg-emerald-900/40 
                               :class="{ 'bg-emerald-100/80 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 shadow-md ring-1 ring-emerald-500/30': open || isActive }"
                               class="text-gray-700 dark:text-gray-300">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <i data-lucide="trash-2" class="w-4 sm:w-5 h-4 sm:h-5"></i>
                        <span>Sampah</span>
                    </div>
                    <i :class="{ 'rotate-90': open }" data-lucide="chevron-right" class="w-3 sm:w-4 h-3 sm:h-4 transition-transform"></i>
                </button>

                <div x-show="open" x-collapse class="mt-1 space-y-1 pl-4 sm:pl-6">
                    <a href="{{ route('admin.sampah.index') }}"
                       class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 
                              hover:bg-gray-100/60 dark:hover:bg-gray-800/50 rounded-lg transition-all">
                        <i data-lucide="package" class="w-3 sm:w-4 h-3 sm:h-4"></i>
                        <span>Jenis Sampah</span>
                    </a>
                    <a href="{{ route('admin.penjualan.index') }}"
                       class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 
                              hover:bg-gray-100/60 dark:hover:bg-gray-800/50 rounded-lg transition-all">
                        <i data-lucide="dollar-sign" class="w-3 sm:w-4 h-3 sm:h-4"></i>
                        <span>Penjualan Sampah</span>
                    </a>
                </div>
            </div>

            <!-- Artikel & Galeri -->
            <a href="{{ route('admin.articles.index') }}"
               class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-sm sm:text-base font-medium 
                      transition-all hover:bg-emerald-100/70 dark:hover:bg-emerald-900/40 
                      {{ Route::is('admin.articles.*') ? 'bg-emerald-100/80 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 shadow-md ring-1 ring-emerald-500/30' : 'text-gray-700 dark:text-gray-300' }}">
                <i data-lucide="file-text" class="w-4 sm:w-5 h-4 sm:h-5"></i>
                <span>Artikel</span>
            </a>

            <a href="{{ route('admin.galleries.index') }}"
               class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-sm sm:text-base font-medium 
                      transition-all hover:bg-emerald-100/70 dark:hover:bg-emerald-900/40 
                      {{ Route::is('admin.galleries.*') ? 'bg-emerald-100/80 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 shadow-md ring-1 ring-emerald-500/30' : 'text-gray-700 dark:text-gray-300' }}">
                <i data-lucide="image" class="w-4 sm:w-5 h-4 sm:h-5"></i>
                <span>Galeri</span>
            </a>
        </nav>

        {{-- Settings --}}
        <div class="p-3 sm:p-4 border-t border-white/20 dark:border-gray-800/40">
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-2 sm:gap-3 px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-medium 
                               transition-all hover:bg-gray-100/70 dark:hover:bg-gray-800/60 text-gray-700 dark:text-gray-300">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <i data-lucide="settings" class="w-4 sm:w-5 h-4 sm:h-5"></i>
                        <span>Pengaturan</span>
                    </div>
                    <i :class="{ 'rotate-90': open }" data-lucide="chevron-right" class="w-3 sm:w-4 h-3 sm:h-4 transition-transform"></i>
                </button>

                <div x-show="open" x-collapse class="mt-1 space-y-1 pl-4 sm:pl-8">
                    <a href="{{ route('admin.profile.edit') }}"
                       class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 
                              hover:bg-gray-100/60 dark:hover:bg-gray-800/50 rounded-lg transition-all">
                        <i data-lucide="user-cog" class="w-3 sm:w-4 h-3 sm:h-4"></i>
                        <span>Profil Saya</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-red-600 dark:text-red-400 
                                       hover:bg-red-50/70 dark:hover:bg-red-900/30 rounded-lg transition-all text-left">
                            <i data-lucide="log-out" class="w-3 sm:w-4 h-3 sm:h-4"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- LOGO TAP UNTUK BUKA SIDEBAR (mobile only) --}}
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="toggleSidebar()"
                    class="p-2.5 rounded-xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl 
                           shadow-lg hover:shadow-xl transition-all 
                           hover:scale-110 active:scale-95">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 
                            flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="SIMBAHSARI" class="w-full h-full object-contain p-1 rounded-xl">
                </div>
            </button>
        </div>

        {{-- Dark Mode Toggle --}}
        <div class="fixed top-4 right-4 z-50">
            <button @click="$store.darkMode.toggle()"
                    class="p-2.5 rounded-xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl 
                           shadow-lg hover:shadow-xl transition-all">
                <template x-if="!$store.darkMode.enabled">
                    <i data-lucide="moon" class="w-5 h-5 text-gray-600"></i>
                </template>
                <template x-if="$store.darkMode.enabled">
                    <i data-lucide="sun" class="w-5 h-5 text-yellow-500"></i>
                </template>
            </button>
        </div>

        {{-- Content Area --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-emerald-50/30 via-teal-50/20 to-cyan-50/20 
                         dark:from-gray-900/50 dark:to-gray-850">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Overlay: Tutup saat klik luar --}}
    <div x-show="sidebarOpen && window.innerWidth < 1024"
         x-transition.opacity
         @click="closeSidebar()"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>