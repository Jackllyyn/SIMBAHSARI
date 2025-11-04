{{-- resources/views/public/galeri/index.blade.php --}}
@extends('layouts.guest')
@section('title', 'Galeri Kegiatan')
@section('content')
<div class="container mx-auto px-4 py-20">
    <h1 class="text-5xl font-bold text-center mb-16 text-green-700 font-display">Galeri Kegiatan</h1>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 max-w-7xl mx-auto">
        @forelse($galleries as $foto)
            @php
                $path = $foto->image_path; // GANTI DARI $foto->image
                $fullPath = public_path('storage/' . $path);
                $imageUrl = file_exists($fullPath) && $path
                    ? asset('storage/' . $path)
                    : 'https://via.placeholder.com/600x800/10b981/ffffff?text=No+Image';
            @endphp

            <div class="group relative overflow-hidden rounded-2xl shadow-lg cursor-pointer transform transition hover:scale-105"
                 onclick="openLightbox('{{ $imageUrl }}', '{{ addslashes($foto->title ?? 'Kegiatan') }}')">
                <!-- SKELETON LOADING -->
                <div class="absolute inset-0 bg-gray-200 animate-pulse rounded-2xl"></div>

                <img 
                    src="{{ $imageUrl }}" 
                    alt="{{ $foto->title ?? 'Kegiatan Bank Sampah' }}" 
                    class="w-full h-56 md:h-64 object-cover transition group-hover:scale-110 relative z-10"
                    loading="lazy"
                    onload="this.previousElementSibling?.remove()"
                    onerror="this.src='https://via.placeholder.com/600x800/cccccc/666666?text=Error'"
                >

                @if($foto->title)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-4 z-20">
                        <p class="text-white text-sm font-medium">{{ Str::limit($foto->title, 50) }}</p>
                    </div>
                @endif
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 text-lg py-12">Belum ada foto kegiatan.</p>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $galleries->links('vendor.pagination.tailwind') }}
    </div>
</div>

<!-- LIGHTBOX -->
<div id="lightbox" class="fixed inset-0 bg-black/90 z-[9999] hidden flex items-center justify-center p-4" onclick="this.classList.add('hidden')">
    <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
        <button class="absolute top-4 right-4 text-white text-3xl z-10" onclick="document.getElementById('lightbox').classList.add('hidden')">&times;</button>
        <img id="lb-img" src="" class="w-full h-auto max-h-screen object-contain rounded-lg">
        <p id="lb-cap" class="text-white text-center mt-4 text-lg font-medium"></p>
    </div>
</div>

<script>
    function openLightbox(src, cap) {
        document.getElementById('lb-img').src = src;
        document.getElementById('lb-cap').textContent = cap;
        document.getElementById('lightbox').classList.remove('hidden');
    }
</script>
@endsection