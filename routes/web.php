<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OutageController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SimulasiController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/simulasi', [SimulasiController::class, 'index'])->name('simulasi');
Route::post('/simulasi', [SimulasiController::class, 'hitung'])->name('simulasi.hitung');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk');

// ── Pembayaran QRIS & Simulasi Scan ──
Route::get('/bayar/qris', [PembayaranController::class, 'qris'])->name('qris.tampil');
Route::get('/bayar/qris/simulasi/{kode}', [PembayaranController::class, 'simulasi'])->name('qris.simulasi');
Route::get('/bayar/qris/check/{kode}', [PembayaranController::class, 'checkStatus'])->name('qris.check');

// News (publik)
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// ── Auth Required Routes ──
Route::middleware('auth')->group(function () {
    // Layanan Produk
    Route::get('/produk/tagihan', [ProdukController::class, 'tagihan'])->name('produk.tagihan');
    Route::post('/produk/tagihan/cek', [ProdukController::class, 'cekTagihan'])->name('produk.cekTagihan');
    Route::get('/produk/token', [ProdukController::class, 'token'])->name('produk.token');
    Route::post('/produk/token/cek', [ProdukController::class, 'cekToken'])->name('produk.cekToken');

    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/tagihan', [DashboardController::class, 'tagihan'])->name('dashboard.tagihan');
    Route::get('/dashboard/token', [DashboardController::class, 'token'])->name('dashboard.token');
    Route::get('/dashboard/simulasi', [DashboardController::class, 'simulasiKeuangan'])->name('dashboard.simulasi');
    Route::get('/dashboard/metering', [DashboardController::class, 'selfMetering'])->name('dashboard.metering');
    Route::post('/dashboard/metering', [DashboardController::class, 'storeMeterReading'])->name('dashboard.metering.store');
    Route::get('/dashboard/monitoring', [DashboardController::class, 'monitoring'])->name('dashboard.monitoring');

    // Outage report
    Route::get('/dashboard/outage', [OutageController::class, 'index'])->name('dashboard.outage');
    Route::get('/dashboard/outage/create', [OutageController::class, 'create'])->name('dashboard.outage.create');
    Route::post('/dashboard/outage', [OutageController::class, 'store'])->name('dashboard.outage.store');

    // PLN Reward
    Route::get('/dashboard/reward', [RewardController::class, 'index'])->name('dashboard.reward');

    // Pembayaran
    Route::post('/produk/bayar', [ProdukController::class, 'bayar'])->name('produk.bayar');
    Route::post('/produk/konfirmasi/{transaction}', [ProdukController::class, 'konfirmasi'])->name('produk.konfirmasi');
    Route::get('/produk/sukses/{transaction}', [ProdukController::class, 'sukses'])->name('produk.sukses');

    // Profile (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Admin Routes ──
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/customers/create', [AdminController::class, 'createCustomer'])->name('customers.create');
    Route::post('/customers', [AdminController::class, 'storeCustomer'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [AdminController::class, 'editCustomer'])->name('customers.edit');
    Route::put('/customers/{customer}', [AdminController::class, 'updateCustomer'])->name('customers.update');
    Route::delete('/customers/{customer}', [AdminController::class, 'deleteCustomer'])->name('customers.delete');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
});

require __DIR__.'/auth.php';
