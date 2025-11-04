{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.public')

@section('title', 'Login - Bank Sampah Indah Sari')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-teal-50 to-emerald-50 px-4 py-8 sm:py-12">
    <div class="w-full max-w-md">
        <!-- Logo dengan Background -->
        <div class="flex justify-center mb-8 animate-fade-in">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full blur-xl opacity-70 scale-110"></div>
                <div class="relative bg-black p-4 rounded-full shadow-lg border border-emerald-100">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Bank Sampah Indah Sari" 
                         class="w-20 h-20 sm:w-24 sm:h-24 object-contain">
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl p-6 sm:p-8 border border-emerald-100">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-6">Masuk ke Akun</h2>

            <x-auth-session-status class="mb-4 text-center text-sm text-emerald-700" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium text-sm sm:text-base" />
                    <x-text-input 
                        id="email" 
                        type="email" 
                        name="email" 
                        :value="old('email')"
                        class="mt-1 block w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition-all duration-200 text-sm sm:text-base"
                        required 
                        autofocus 
                        placeholder="contoh@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium text-sm sm:text-base" />
                    <x-text-input 
                        id="password" 
                        type="password" 
                        name="password"
                        class="mt-1 block w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 transition-all duration-200 text-sm sm:text-base"
                        required 
                        placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
                </div>

                <!-- Remember & Register Link -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs sm:text-sm">
                    <label class="flex items-center text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                        <span class="ml-2">{{ __('Ingat saya') }}</span>
                    </label>
                    <a href="{{ route('register') }}" 
                       class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                        {{ __('Belum punya akun?') }}
                    </a>
                </div>

                <!-- Submit Button -->
                <x-primary-button class="w-full justify-center py-3 text-base sm:text-lg font-semibold bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                    {{ __('Masuk') }}
                </x-primary-button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-500 mt-6 opacity-80">
            &copy; {{ date('Y') }} <span class="hidden sm:inline">• </span><br class="sm:hidden">Bank Sampah Indah Sari • Desa Dukuhbangsa
        </p>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }
</style>
@endsection