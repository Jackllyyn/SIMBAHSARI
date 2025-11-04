{{-- resources/views/home.blade.php --}}
@extends('layouts.guest')

@section('title', 'Bank Sampah Simbah Sari – Ubah Sampah Jadi Harta')

@section('content')
<!-- LOADING SCREEN – ANIMASI MENARIK -->
<div id="loading" class="fixed inset-0 bg-gradient-to-br from-green-50 via-green-100 to-green-200 z-50 flex items-center justify-center overflow-hidden">
    <div class="text-center" data-aos="fade-up" data-aos-delay="100">
        <!-- Logo + Daun Berputar -->
        <div class="mb-6 relative inline-block">
            <svg width="100" height="100" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                <circle cx="60" cy="60" r="55" fill="white" stroke="#22c55e" stroke-width="3"/>
                <path d="M35 75 L60 50 L85 75 V95 H35 Z" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round"/>
                <g class="animate-spin-slow" transform="translate(60,35)">
                    <path d="M0,-12 Q8,-8 10,0 Q8,8 0,12 Q-8,8 -10,0 Q-8,-8 0,-12" fill="#4ade80"/>
                </g>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-16 h-16 border-4 border-green-200 border-t-green-600 rounded-full animate-spin"></div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-64 mx-auto mb-6 bg-white rounded-full overflow-hidden shadow-inner">
            <div id="progress" class="h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
        </div>

        <!-- Teks Memuat -->
        <p class="text-green-700 font-display text-lg font-semibold flex items-center justify-center gap-1">
            Memuat
            <span class="dots inline-block w-8 text-center">...</span>
        </p>
    </div>
</div>

<!-- HERO -->
<section class="relative min-h-screen bg-gradient-to-br from-green-50 via-green-100 to-green-200 overflow-hidden flex items-center justify-center px-4 py-16">
    <!-- Floating Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-10 left-10 animate-float"><i data-lucide="leaf" class="w-12 h-12 text-green-400 opacity-70"></i></div>
        <div class="absolute top-20 right-20 animate-float-delay"><i data-lucide="leaf" class="w-10 h-10 text-green-500 opacity-60"></i></div>
        <div class="absolute bottom-32 left-32 animate-float"><i data-lucide="recycle" class="w-14 h-14 text-green-600 opacity-50"></i></div>
        <div class="absolute bottom-10 right-10 animate-float-delay"><i data-lucide="trash-2" class="w-12 h-12 text-green-500 opacity-60"></i></div>
        <div class="absolute top-1/2 left-1/4 animate-pulse-slow"><i data-lucide="package" class="w-10 h-10 text-green-400"></i></div>
        <div class="absolute top-1/3 right-1/3 animate-float-delay"><i data-lucide="sparkles" class="w-8 h-8 text-yellow-400 opacity-70"></i></div>
    </div>

    <!-- Rotating Leaf Center -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-20">
        <i data-lucide="leaf" class="w-32 h-32 text-green-600 animate-spin-slow"></i>
    </div>

    <div class="relative z-10 text-center max-w-4xl mx-auto" data-aos="fade-up">
        <!-- Logo -->
        <div class="mb-6 flex justify-center">
            <svg width="80" height="80" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="60" r="55" fill="#ffffff50" stroke="#22c55e" stroke-width="2"/>
                <path d="M35 75 L60 50 L85 75 V95 H35 Z" fill="none" stroke="#16a34a" stroke-width="2.5"/>
                <g class="animate-spin-slow" transform="translate(60,35)">
                    <path d="M0,-12 Q8,-8 10,0 Q8,8 0,12 Q-8,8 -10,0 Q-8,-8 0,-12" fill="#4ade80"/>
                </g>
            </svg>
        </div>

        <h1 class="text-5xl md:text-7xl font-bold font-display mb-6 leading-tight">
            Jadi <span class="bg-gradient-to-r from-green-600 to-green-400 bg-clip-text text-transparent">Pahlawan</span><br>
            <span class="bg-gradient-to-r from-green-500 to-green-700 bg-clip-text text-transparent">Bumi</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-700 mb-8 max-w-2xl mx-auto flex items-center justify-center gap-2">
            <i data-lucide="recycle" class="w-6 h-6 text-green-600"></i>
            Setor sampah, dapatkan uang, selamatkan lingkungan!
            <i data-lucide="leaf" class="w-6 h-6 text-green-600"></i>
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full transition transform hover:-translate-y-1 shadow-lg">
                <i data-lucide="user-plus"></i> Daftar Gratis
            </a>
            <a href="#pengakuan" class="inline-flex items-center gap-2 border-2 border-green-500 text-green-600 hover:bg-green-500 hover:text-white font-bold py-3 px-8 rounded-full transition">
                <i data-lucide="trophy"></i> Lihat Prestasi
            </a>
        </div>
    </div>
</section>

<!-- STATS -->
@php
    use App\Models\Nasabah;
    use App\Models\PenjualanSampah;
    $nasabah = Nasabah::count();
    $ton = number_format(PenjualanSampah::sum('berat') / 1000, 1);
@endphp

<div class="container mx-auto px-4 -mt-16 relative z-20" data-aos="fade-up">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-xl text-center transform transition hover:-translate-y-3 border-t-4 border-green-500">
            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                <i data-lucide="users"></i>
            </div>
            <div class="text-4xl font-bold text-green-700 font-display">{{ $nasabah }}+</div>
            <div class="text-sm text-gray-600 mt-1 flex items-center justify-center gap-1">
                <i data-lucide="user-check" class="w-4 h-4 text-green-600"></i> Nasabah Aktif
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-xl text-center transform transition hover:-translate-y-3 border-t-4 border-green-500">
            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                <i data-lucide="scale"></i>
            </div>
            <div class="text-4xl font-bold text-green-700 font-display">{{ $ton }} Ton</div>
            <div class="text-sm text-gray-600 mt-1 flex items-center justify-center gap-1">
                <i data-lucide="package" class="w-4 h-4 text-green-600"></i> Sampah Terkumpul
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-xl text-center transform transition hover:-translate-y-3 border-t-4 border-green-500">
            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                <i data-lucide="award"></i>
            </div>
            <div class="text-4xl font-bold text-green-700 font-display">12+</div>
            <div class="text-sm text-gray-600 mt-1 flex items-center justify-center gap-1">
                <i data-lucide="star" class="w-4 h-4 text-yellow-500"></i> Penghargaan
            </div>
        </div>
    </div>
</div>

<!-- PENGAKUAN & GALERI -->
<section id="pengakuan" class="py-20 bg-white" data-aos="fade-up">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-green-700 font-display flex items-center gap-3">
                    <i data-lucide="trophy" class="w-10 h-10 text-yellow-500"></i>
                    Diakui & Dipercaya
                </h2>
                <p class="text-gray-600 mb-6 leading-relaxed flex items-start gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mt-0.5"></i>
                    Telah meraih penghargaan dari pemerintah & lembaga lingkungan.
                </p>
                <p class="text-gray-600 mb-8 flex items-start gap-2">
                    <i data-lucide="heart" class="w-5 h-5 text-red-500 mt-0.5"></i>
                    Gabung gerakan <strong class="text-green-600">#SETORinAja</strong> untuk bumi lebih hijau!
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('articles.index') ?? '#artikel' }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition flex items-center justify-center gap-2">
                        <i data-lucide="file-text"></i> Baca Artikel
                    </a>
                    <a href="{{ route('galeri') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition flex items-center justify-center gap-2">
                        <i data-lucide="image"></i> Lihat Galeri
                    </a>
                </div>
            </div>

            <!-- GALERI – KARTU LEBAR + LIGHTBOX -->
            <div class="relative h-72 md:h-96">
                <div class="absolute inset-0 flex items-center justify-center perspective-1000">
                    @php
                        $displayGalleries = $galleries->take(4);
                        $total = $displayGalleries->count();
                    @endphp

                    @forelse($displayGalleries as $index => $foto)
                        @php
                            $rotate = ($index - ($total - 1) / 2) * 7;
                            $zIndex = 40 - $index;
                            $delay = $index * 120;

                            $imagePath = $foto->image_path;
                            $fullPath = public_path('storage/' . $imagePath);
                            $imageUrl = (is_string($imagePath) && file_exists($fullPath))
                                ? asset('storage/' . $imagePath)
                                : 'https://via.placeholder.com/800x1000/10b981/ffffff?text=No+Image';
                        @endphp

                        <div 
                            class="absolute transform-gpu transition-all duration-500 hover:scale-105 hover:z-50 cursor-pointer"
                            style="
                                transform: rotate({{ $rotate }}deg) translateX({{ ($index - 1.5) * 28 }}px);
                                z-index: {{ $zIndex }};
                                animation-delay: {{ $delay }}ms;
                            "
                            data-aos="zoom-in-up" 
                            data-aos-delay="{{ $delay }}"
                            onclick="openLightbox('{{ $imageUrl }}', '{{ addslashes($foto->title ?? 'Kegiatan Bank Sampah') }}')"
                        >
                            <div class="relative w-52 h-72 md:w-64 md:h-88 bg-white rounded-2xl shadow-2xl overflow-hidden border-4 border-white transform hover:rotate-0 hover:shadow-3xl transition-all duration-300">
                                <img 
                                    src="{{ $imageUrl }}" 
                                    alt="{{ $foto->title ?? 'Galeri' }}"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                    onerror="this.src='https://via.placeholder.com/800x1000/cccccc/666666?text=Error'"
                                >
                                <!-- Hover Caption + Zoom -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 hover:opacity-100 transition-all duration-300 flex items-end p-4">
                                    <p class="text-white text-sm font-medium truncate w-full">{{ $foto->title ?? 'Kegiatan' }}</p>
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                    <i data-lucide="zoom-in" class="w-12 h-12 text-white"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        @for($i = 0; $i < 3; $i++)
                            @php $rotate = ($i - 1) * 9; @endphp
                            <div 
                                class="absolute transform-gpu cursor-pointer"
                                style="transform: rotate({{ $rotate }}deg) translateX({{ ($i - 1) * 28 }}px); z-index: {{ 30 - $i }};"
                                data-aos="fade-in" data-aos-delay="{{ $i * 180 }}"
                                onclick="openLightbox('https://via.placeholder.com/800x1000/10b981/ffffff?text=Belum+Ada+Foto', 'Belum Ada Foto')"
                            >
                                <div class="w-52 h-72 md:w-64 md:h-88 bg-gray-50 rounded-2xl shadow-xl border-4 border-white flex flex-col items-center justify-center p-6 text-center">
                                    <i data-lucide="camera-off" class="w-14 h-14 text-gray-300 mb-3"></i>
                                    <p class="text-xs text-gray-500 font-medium">Foto belum tersedia</p>
                                </div>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </div>

            </div>
</section>

<!-- LIGHTBOX POP-UP -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-[9999] hidden flex items-center justify-center p-4" onclick="closeLightbox()">
    <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
        <button class="absolute top-4 right-4 text-white hover:text-gray-300 text-3xl z-10" onclick="closeLightbox()">
            <i data-lucide="x"></i>
        </button>
        <img id="lightbox-image" src="" alt="" class="w-full h-auto max-h-screen object-contain rounded-lg shadow-2xl">
        <p id="lightbox-caption" class="text-white text-center mt-4 text-lg font-medium"></p>
    </div>
</div>

<!-- 3R -->
<section class="py-20 bg-green-50" data-aos="fade-up">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-16 text-green-700 font-display flex items-center justify-center gap-3">
            <i data-lucide="refresh-cw" class="w-10 h-10 text-green-600"></i>
            Prinsip 3R
        </h2>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="bg-white p-8 rounded-3xl shadow-xl text-center border-t-4 border-red-500">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="minus" class="w-10 h-10 text-red-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">Reduce</h3>
                <p class="text-gray-600 text-sm">Kurangi penggunaan barang sekali pakai</p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-xl text-center border-t-4 border-yellow-500">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="refresh-cw" class="w-10 h-10 text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">Reuse</h3>
                <p class="text-gray-600 text-sm">Pakai ulang barang yang masih layak</p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-xl text-center border-t-4 border-green-500">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="recycle" class="w-10 h-10 text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">Recycle</h3>
                <p class="text-gray-600 text-sm">Daur ulang jadi produk baru</p>
            </div>
        </div>
    </div>
</section>

<!-- TENTANG KAMI -->
<section id="tentang" class="py-20 bg-white" data-aos="fade-up">
    <div class="container mx-auto px-4 max-w-4xl text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-8 text-green-700 font-display flex items-center justify-center gap-3">
            <i data-lucide="info" class="w-10 h-10 text-green-600"></i>
            Tentang Kami
        </h2>
        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
            <strong class="text-green-700">Bank Sampah Simbah Sari</strong> adalah unit pengelolaan sampah terpadu di Desa Dukuhbangsa. 
            Didirikan tahun 2020, kami telah mengumpulkan 
            <span class="text-green-600 font-bold">{{ $ton }} ton sampah</span> 
            dan memberdayakan masyarakat melalui ekonomi sirkular.
        </p>
        <a href="{{ route('about') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full inline-flex items-center gap-2 transition transform hover:-translate-y-1 shadow-lg">
            <i data-lucide="arrow-right"></i> Pelajari Lebih Lanjut
        </a>
    </div>
</section>

<!-- TESTIMONI -->
<section class="py-20 bg-green-50" data-aos="fade-up">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-green-700 font-display">
            <i data-lucide="message-square" class="w-8 h-8 inline-block"></i> Apa Kata Nasabah?
        </h2>

        <!-- Slider Testimoni -->
        <div x-data="testiSlider({{ $testimonials->toJson() }})" x-init="lucide.createIcons()" class="max-w-2xl mx-auto mb-12">
            <template x-for="(t, i) in items" :key="i">
                <div x-show="i === idx" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white p-5 rounded-2xl shadow-lg border border-green-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            <span x-text="t.name.charAt(0).toUpperCase()"></span>
                        </div>
                        <div>
                            <div class="font-semibold text-sm" x-text="t.name"></div>
                            <div class="text-xs text-gray-500" x-text="t.occupation || 'Nasabah'"></div>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-2">
                        <template x-for="n in 5" :key="n">
                            <i :class="n <= (t.rating || 5) ? 'text-yellow-400' : 'text-gray-300'" data-lucide="star" class="w-4 h-4 fill-current"></i>
                        </template>
                    </div>
                    <p class="text-gray-700 text-sm italic leading-relaxed" x-text="t.content"></p>
                </div>
            </template>
            <div class="flex justify-center gap-2 mt-6">
                <template x-for="(t, i) in items" :key="i">
                    <button @click="idx = i" :class="i === idx ? 'bg-green-600 w-8' : 'bg-gray-300 w-2'" class="h-2 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>

        <!-- Form Testimoni -->
        <div x-data="formTesti()" x-init="lucide.createIcons()" class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-xl border border-green-100">
            <h3 class="text-lg font-bold text-center mb-5 text-green-700 flex items-center justify-center gap-2">
                <i data-lucide="pencil" class="w-5 h-5"></i> Tulis Testimoni Anda
            </h3>
            <form @submit.prevent="submit" class="space-y-4 text-sm">
                <input type="text" x-model="form.name" placeholder="Nama Lengkap" required class="w-full px-3 py-2 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm">
                <input type="text" x-model="form.occupation" placeholder="Pekerjaan (opsional)" class="w-full px-3 py-2 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm">
                <div class="flex gap-1 justify-center">
                    <template x-for="n in 5" :key="n">
                        <button type="button" @click="form.rating = n" class="p-0 bg-transparent border-0 transition transform hover:scale-110">
                            <i :class="n <= form.rating ? 'text-yellow-400' : 'text-gray-300'" data-lucide="star" class="w-7 h-7 fill-current"></i>
                        </button>
                    </template>
                </div>
                <textarea x-model="form.content" placeholder="Ceritakan pengalaman Anda..." required rows="3" class="w-full px-3 py-2 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-100 focus:border-green-500 text-sm"></textarea>
                <button type="submit" :disabled="loading" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-lg transition disabled:opacity-60 text-sm">
                    <span x-show="!loading">Kirim Testimoni</span>
                    <span x-show="loading">Mengirim...</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-20 bg-white" data-aos="fade-up">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-green-700 font-display">
            <i data-lucide="help-circle" class="w-8 h-8 inline-block"></i> Pertanyaan Umum
        </h2>
        <div class="space-y-4">
            @foreach([
                ['Sampah apa yang diterima?', 'Plastik, kertas, kardus, botol, kaleng, logam.'],
                ['Berapa bayaran per kg?', 'Plastik: Rp2.000 | Kertas: Rp1.500 | Botol: Rp3.000'],
                ['Jam operasional?', 'Senin–Jumat: 08.00–16.00 | Sabtu: 09.00–14.00'],
                ['Bisa daftar online?', 'Ya! Daftar gratis di website ini.']
            ] as $faq)
                <details class="bg-green-50 p-5 rounded-xl shadow-sm cursor-pointer border border-green-100">
                    <summary class="font-semibold text-gray-800 flex justify-between items-center">
                        {{ $faq[0] }}
                        <i data-lucide="chevron-down" class="w-5 h-5 text-green-600 transition transform"></i>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm">{{ $faq[1] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="py-24 bg-gradient-to-br from-green-600 to-green-800 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-6xl font-bold mb-6 font-display">Setor Sampah, Dapat Uang!</h2>
        <p class="text-xl mb-10 max-w-3xl mx-auto opacity-90">
            Ubah sampah jadi pemasukan, bantu lingkungan, dan jadi pahlawan lokal.
        </p>
        <a href="{{ route('register') }}" class="bg-yellow-400 text-green-900 font-bold px-10 py-5 rounded-full text-lg hover:bg-yellow-300 transition inline-flex items-center gap-3 shadow-xl transform hover:-translate-y-1">
            <i data-lucide="user-plus"></i> Daftar & Mulai Setor
        </a>
    </div>
</section>

<!-- CSS KHUSUS -->
<style>
    .perspective-1000 { perspective: 1000px; }
    .transform-gpu { transform-style: preserve-3d; backface-visibility: hidden; }
    #lightbox { animation: fadeIn 0.3s ease-out; }
    #lightbox.hidden { display: none; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .h-88 { height: 22rem; } /* 88 * 0.25rem */
</style>

<!-- SCRIPT KHUSUS HOME -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Loading Animation
        let progress = 0;
        const progressBar = document.getElementById('progress');
        const dots = document.querySelector('.dots');
        const loadingScreen = document.getElementById('loading');

        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;
            progressBar.style.width = progress + '%';
            const dotCount = Math.floor(progress / 33) + 1;
            dots.textContent = '.'.repeat(dotCount);

            if (progress >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    loadingScreen.style.opacity = '0';
                    loadingScreen.style.transform = 'scale(0.95)';
                    setTimeout(() => loadingScreen.remove(), 600);
                }, 300);
            }
        }, 200);

        // Re-render Lucide icons
        window.addEventListener('alpine:init', () => lucide.createIcons());
        setTimeout(() => lucide.createIcons(), 100);
    });

    // KEMBALI KE ATAS SAAT REFRESH
    window.addEventListener('load', () => {
        window.scrollTo(0, 0);
    });

    // SMOOTH SCROLL KE SECTION
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // LIGHTBOX
    function openLightbox(imageUrl, caption) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-image');
        const cap = document.getElementById('lightbox-caption');

        img.src = imageUrl;
        cap.textContent = caption;
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        lucide.createIcons();
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });

    // Testimonial Slider
    function testiSlider(items) {
        return {
            items: items.map(t => ({ ...t, rating: t.rating || 5 })),
            idx: 0,
            init() { 
                if (this.items.length > 1) setInterval(() => this.idx = (this.idx + 1) % this.items.length, 7000);
            }
        };
    }

    // Form Testimoni
    function formTesti() {
        return {
            form: { name: '', occupation: '', content: '', rating: 5 },
            loading: false,
            async submit() {
                this.loading = true;
                try {
                    const res = await fetch('{{ route('testimonials.store') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                        body: JSON.stringify(this.form)
                    });
                    if (res.ok) {
                        alert('Terima kasih! Testimoni Anda telah dikirim.');
                        this.form = { name: '', occupation: '', content: '', rating: 5 };
                        setTimeout(() => location.reload(), 1000);
                    } else alert('Gagal mengirim.');
                } catch { alert('Error koneksi.'); } finally { this.loading = false; }
            }
        };
    }
</script>
@endsection