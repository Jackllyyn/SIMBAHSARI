@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8">
        <div class="flex items-center gap-5 mb-8">
            <div class="relative">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 p-1">
                    <div class="w-full h-full rounded-full bg-white dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                        @if (auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </span>
                        @endif
                    </div>
                </div>
                <label class="absolute bottom-0 right-0 w-8 h-8 bg-purple-600 hover:bg-purple-700 rounded-full flex items-center justify-center cursor-pointer shadow-lg transition">
                    <i data-lucide="camera" class="w-4 h-4 text-white"></i>
                    <input type="file" name="photo" class="hidden" x-ref="photoInput" @change="handlePhotoChange">
                </label>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Profil Admin</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Kelola informasi akun Anda</p>
            </div>
        </div>

        @if (session('status') === 'profile-updated')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Profil berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" x-data="profileForm()">
            @csrf
            @method('patch')

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           required>
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                           required>
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Password Fields -->
            <div class="mt-6 grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password Baru <span class="text-xs text-gray-500">(kosongkan jika tidak ingin ganti)</span>
                    </label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                </div>
            </div>

            <!-- Photo Upload -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ganti Foto Profil (Opsional)</label>
                <div class="flex items-center gap-3">
                    <button type="button" @click="$refs.photoInput.click()"
                            class="px-4 py-2 text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/30 dark:hover:bg-purple-900/50 rounded-lg transition">
                        Pilih Foto
                    </button>
                    <span x-text="photoName" class="text-sm text-gray-600 dark:text-gray-400"></span>
                </div>
                @error('photo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg hover:from-purple-700 hover:to-pink-700 shadow-md hover:shadow-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function profileForm() {
    return {
        photoName: '',
        handlePhotoChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.photoName = file.name;
            }
        }
    }
}
</script>
@endsection