<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bank Sampah SIMBAHSARI - Nasabah</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 min-h-screen">

<div x-data="{ open: false }" class="flex h-screen overflow-hidden md:overflow-auto">

    <!-- Sidebar -->
    <div 
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-2xl transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 border-r border-gray-200 dark:border-gray-700"
        :class="{ '-translate-x-full': !open }"
    >
        <!-- Header Sidebar -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                SIMBAHSARI
            </a>
            <button @click="open = false" class="md:hidden text-gray-600 dark:text-gray-300 hover:text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('nasabah.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors {{ request()->routeIs('nasabah.dashboard') ? 'bg-blue-50 dark:bg-blue-900 font-medium' : '' }}">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-md border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between p-4">
                <!-- Hamburger: Berubah jadi X saat terbuka -->
                <button @click="open = !open" class="md:hidden text-gray-600 dark:text-gray-300 z-50 hover:text-blue-500 transition-colors" aria-label="Toggle Menu">
                    <template x-if="!open">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </template>
                    <template x-if="open">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </template>
                </button>
                <div></div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-y-auto bg-gray-50 dark:bg-gray-900">
            @yield('content')
        </main>
    </div>

    <!-- Overlay -->
    <template x-if="open">
        <div 
            @click="open = false"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 md:hidden"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>
    </template>

</div>

@stack('scripts')
</body>
</html>