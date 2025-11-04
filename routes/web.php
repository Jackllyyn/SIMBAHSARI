<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NasabahController as AdminNasabahController;
use App\Http\Controllers\Admin\SampahController;
use App\Http\Controllers\Admin\SetoranSampahController;
use App\Http\Controllers\Admin\PenjualanSampahController;
use App\Http\Controllers\Admin\PenarikanController;
use App\Http\Controllers\Nasabah\NasabahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// === PUBLIK ===
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
// === ARTIKEL PUBLIK ===
Route::get('/artikel', [PublicController::class, 'articles'])->name('articles.index');
Route::get('/artikel/{article}', [PublicController::class, 'articleShow'])->name('articles.show');
Route::post('/testimonials', [PublicController::class, 'storeTestimonial'])->name('testimonials.store');

// === GUEST ===
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// === AUTHENTICATED ===
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// === ADMIN ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // === SAMPAH RESOURCE (BARU DITAMBAHKAN) ===
    Route::resource('sampah', SampahController::class)->except(['show']);

    // === SAMPAH JENIS (CUSTOM ROUTES) ===
    Route::get('/sampah/create-jenis', [SampahController::class, 'createJenis'])->name('sampah.create_jenis');
    Route::post('/sampah/store-jenis', [SampahController::class, 'storeJenis'])->name('sampah.store_jenis');
    Route::get('/sampah/{jenisSampah}/edit-jenis', [SampahController::class, 'editJenis'])->name('sampah.edit_jenis');
    Route::patch('/sampah/{jenisSampah}/update-jenis', [SampahController::class, 'updateJenis'])->name('sampah.update_jenis');

    // === NASABAH RESOURCE ===
    Route::resource('nasabah', AdminNasabahController::class)->except(['show']);

    // === RESOURCE LAIN ===
    Route::resource('setoran_sampah', SetoranSampahController::class);
    Route::resource('penjualan', PenjualanSampahController::class);
    Route::resource('penarikans', PenarikanController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('galleries', GalleryController::class)->except(['show']);
    Route::resource('articles', ArticleController::class)->except(['show']);

    // === LAPORAN ===
    Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'excel'])->name('laporan.excel');

    // === PROFILE ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === NASABAH ===
Route::middleware(['auth', 'role:nasabah'])->prefix('nasabah')->name('nasabah.')->group(function () {
    Route::get('/dashboard', [NasabahController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile/edit', [NasabahController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [NasabahController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/password', [NasabahController::class, 'updatePassword'])->name('password.update');
});