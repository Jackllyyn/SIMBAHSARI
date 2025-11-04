@extends('layouts.nasabah')

@section('content')
<div class="container mx-auto p-4 md:p-6 max-w-6xl">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        
        <!-- HEADER -->
        <div class="bg-gradient-to-r from-blue-600 to-green-600 dark:from-blue-700 dark:to-green-700 p-6 text-white">
            <h1 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7 0 00-13.074.003z"/>
                </svg>
                Edit Profil Nasabah
            </h1>
            <p class="text-sm opacity-90 mt-1">Perbarui informasi dan keamanan akun Anda</p>
        </div>

        <div class="p-6 md:p-8">
            @if(session('success'))
                <div class="alert alert-success shadow-md mb-6 flex items-center gap-2 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error shadow-md mb-6 rounded-xl">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- GRID: FORM + SALDO -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- KOLOM KIRI: FORM EDIT PROFIL -->
                <div class="lg:col-span-2 space-y-6">
                    <form action="{{ route('nasabah.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        <!-- Foto Profil -->
                        <div class="flex flex-col sm:flex-row items-center gap-6 p-5 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <div class="avatar group hover:scale-110 transition-transform duration-300">
                                <div class="w-28 h-28 rounded-full ring-4 ring-primary ring-offset-4 ring-offset-base-100 overflow-hidden shadow-lg">
                                    @if($nasabah->foto)
                                        <img src="{{ Storage::url($nasabah->foto) }}" alt="Foto" class="object-cover w-full h-full" />
                                    @else
                                        <div class="bg-gradient-to-br from-blue-500 to-green-500 w-full h-full flex items-center justify-center text-3xl font-bold text-white shadow-inner">
                                            {{ strtoupper(substr($nasabah->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Ganti Foto Profil
                                    </span>
                                </label>
                                <input type="file" name="foto" class="file-input file-input-bordered file-input-sm w-full max-w-xs" accept="image/*"/>
                                <p class="text-xs text-gray-500 mt-1">Maks. 2MB (JPG/PNG)</p>
                            </div>
                        </div>

                        <!-- Input Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">
                                    <span class="label-text font-medium flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Nama Lengkap
                                    </span>
                                </label>
                                <input type="text" name="nama" value="{{ old('nama', $nasabah->nama) }}" class="input input-bordered w-full" required />
                            </div>
                            <div>
                                <label class="label">
                                    <span class="label-text font-medium flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        No. Telepon
                                    </span>
                                </label>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon', $nasabah->no_telepon) }}" class="input input-bordered w-full" placeholder="081234567890" />
                            </div>
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text font-medium flex items-center gap-2">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    Alamat Lengkap
                                </span>
                            </label>
                            <textarea name="alamat" rows="3" class="textarea textarea-bordered w-full resize-none">{{ old('alamat', $nasabah->alamat) }}</textarea>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('nasabah.dashboard') }}" class="btn btn-ghost">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- KOLOM KANAN: CARD SALDO -->
                <!-- KOLOM KANAN: CARD SALDO (TIDAK MEMANJANG KE BAWAH!) -->
<div class="lg:col-span-1">
    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg p-6 text-white flex flex-col h-fit min-h-48 transform hover:scale-105 transition-transform duration-300">
        <div class="flex-1">
            <h3 class="text-lg font-bold mb-2 flex items-center gap-2">
                <svg class="w-7 h-7 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                </svg>
                Total Saldo
            </h3>
            <div class="text-2xl font-bold whitespace-nowrap overflow-hidden text-ellipsis max-w-full">
                Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
            </div>
            <p class="text-sm opacity-90 mt-2">Siap ditarik kapan saja</p>
        </div>
        <div class="mt-4 self-center">
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center animate-pulse">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
            </div>
        </div>
    </div>
</div>
            </div>

            <!-- GANTI PASSWORD (TERPISAH JELAS) -->
            <div class="mt-10 pt-8 border-t-2 border-dashed border-gray-300 dark:border-gray-600">
                <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-100 flex items-center gap-3">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Ganti Password
                </h2>

                <form action="{{ route('nasabah.password.update') }}" method="POST" class="max-w-2xl">
                    @csrf @method('PATCH')

                    <div class="space-y-5">
                        <div>
                            <label class="label">
                                <span class="label-text font-medium">Password Lama</span>
                            </label>
                            <input type="password" name="current_password" class="input input-bordered w-full" required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="label">
                                    <span class="label-text font-medium">Password Baru</span>
                                </label>
                                <input type="password" name="password" class="input input-bordered w-full" required minlength="8" placeholder="Min. 8 karakter" />
                            </div>
                            <div>
                                <label class="label">
                                    <span class="label-text font-medium">Konfirmasi Password</span>
                                </label>
                                <input type="password" name="password_confirmation" class="input input-bordered w-full" required />
                            </div>
                        </div>

                        <div class="flex justify-end pt-3">
                            <button type="submit" class="btn btn-error text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Ganti Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection