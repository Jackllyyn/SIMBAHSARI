{{-- resources/views/public/about.blade.php --}}
@extends('layouts.guest')
@section('title', 'Tentang Kami')
@section('content')
<div class="container mx-auto px-4 py-20 max-w-7xl">
    <h1 class="text-5xl md:text-6xl font-bold text-center mb-16 text-green-700 font-display">
        Tentang <span class="text-green-600">Bank Sampah Simbah Sari</span>
    </h1>

    <!-- SEJARAH -->
    <section class="mb-24" data-aos="fade-up">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-green-800 flex items-center gap-3">
                    <i data-lucide="history" class="w-10 h-10 text-green-600"></i>
                    Sejarah Berdiri
                </h2>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    <strong>Bank Sampah Simbah Sari</strong> didirikan oleh <strong>ibu-ibu warga Desa Dukuh Bangsa, Kabupaten Tegal</strong> pada tahun <strong>2018</strong> sebagai inisiatif komunitas untuk mengelola sampah rumah tangga secara mandiri dan berkelanjutan.
                </p>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    Dimulai dari <strong>kelompok PKK desa</strong>, ibu-ibu ini mengadopsi konsep bank sampah untuk mengubah sampah anorganik menjadi sumber pendapatan keluarga, sekaligus menjaga kebersihan lingkungan desa mereka.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Dari hanya menerima 3 jenis sampah (plastik, kertas, botol), kini kami telah berkembang menjadi bank sampah terbesar di wilayah Dukuh Bangsa dengan <strong>lebih dari 200 nasabah aktif</strong> dan mitra daur ulang lokal.
                </p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl p-8 shadow-xl">
                <img src="https://images.unsplash.com/photo-1558618047-3c8d6a129955?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Ibu-ibu Bank Sampah Simbah Sari" class="w-full h-80 object-cover rounded-2xl shadow-lg">
                <p class="text-sm text-gray-600 mt-2 text-center italic">Ibu-ibu warga Desa Dukuh Bangsa sedang menimbang sampah</p>
            </div>
        </div>
    </section>

    <!-- VISI & MISI -->
    <section class="mb-24" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-green-800">
            Visi & Misi Kami
        </h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 border-l-8 border-green-600 transform transition hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center text-white">
                        <i data-lucide="eye" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-green-700">Visi</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    Menjadi <strong>bank sampah komunitas terdepan di Kabupaten Tegal</strong> yang memberdayakan ibu-ibu warga Desa Dukuh Bangsa untuk menciptakan lingkungan bersih, ekonomi mandiri, dan kesejahteraan berkelanjutan bagi keluarga desa.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 border-l-8 border-yellow-500 transform transition hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center text-white">
                        <i data-lucide="target" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-green-700">Misi</h3>
                </div>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 mt-0.5"></i>
                        <span>Mengajak ibu-ibu desa untuk aktif memilah sampah rumah tangga sejak dini.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 mt-0.5"></i>
                        <span>Memberikan pelatihan dan insentif ekonomi bagi warga desa melalui sistem bank sampah.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 mt-0.5"></i>
                        <span>Menjalin kemitraan dengan pemerintah desa dan industri daur ulang lokal.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 mt-0.5"></i>
                        <span>Menanam pohon dan edukasi anak-anak desa untuk generasi lingkungan yang sadar.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- STRUKTUR ORGANISASI -->
    <section class="mb-24" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-green-800">
            Tim Kami – Ibu-Ibu Warga Desa Dukuh Bangsa
        </h2>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl p-8 shadow-xl">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <!-- Ketua -->
                <div class="group">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-green-600 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Ketua" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-green-800">Ibu Siti Aminah</h3>
                    <p class="text-sm text-gray-600">Ketua Bank Sampah</p>
                    <p class="text-xs text-gray-500 mt-1">Warga Dukuh Bangsa</p>
                </div>

                <!-- Bendahara -->
                <div class="group">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-yellow-500 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Bendahara" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-green-800">Ibu Fatimah</h3>
                    <p class="text-sm text-gray-600">Bendahara</p>
                    <p class="text-xs text-gray-500 mt-1">Warga Dukuh Bangsa</p>
                </div>

                <!-- Sekretaris -->
                <div class="group">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-blue-500 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Sekretaris" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-green-800">Ibu Ratih</h3>
                    <p class="text-sm text-gray-600">Sekretaris</p>
                    <p class="text-xs text-gray-500 mt-1">Warga Dukuh Bangsa</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-700">
                    Didukung oleh <strong>15 ibu-ibu warga desa</strong> dan <strong>kelompok PKK Dukuh Bangsa</strong> sebagai relawan aktif. Bersama-sama menjaga kebersihan desa dan ekonomi keluarga.
                </p>
            </div>
        </div>
    </section>

    <!-- STATISTIK -->
    <section class="mb-20" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-green-800">
            Pencapaian Kami
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-xl text-center transform transition hover:-translate-y-3">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                    <i data-lucide="users"></i>
                </div>
                <div class="text-4xl font-bold text-green-700 font-display">{{ $stats['nasabah'] }}+</div>
                <div class="text-sm text-gray-600 mt-1">Nasabah Aktif</div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-xl text-center transform transition hover:-translate-y-3">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                    <i data-lucide="package"></i>
                </div>
                <div class="text-4xl font-bold text-green-700 font-display">{{ $stats['ton'] }}</div>
                <div class="text-sm text-gray-700 mt-1">Ton Sampah</div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-xl text-center transform transition hover:-translate-y-3">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                    <i data-lucide="trees"></i>
                </div>
                <div class="text-4xl font-bold text-green-700 font-display">{{ $stats['pohon'] }}+</div>
                <div class="text-sm text-gray-600 mt-1">Pohon Ditanam</div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-xl text-center transform transition hover:-translate-y-3">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white">
                    <i data-lucide="award"></i>
                </div>
                <div class="text-4xl font-bold text-green-700 font-display">{{ $stats['penghargaan'] }}+</div>
                <div class="text-sm text-gray-600 mt-1">Penghargaan</div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <div class="text-center" data-aos="fade-up">
        <a href="{{ route('register') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold px-10 py-5 rounded-full text-lg hover:from-green-600 hover:to-green-700 transition transform hover:-translate-y-1 shadow-xl">
            <i data-lucide="user-plus" class="w-6 h-6"></i>
            Bergabung Bersama Ibu-Ibu Simbah Sari
        </a>
    </div>
</div>
@endsection