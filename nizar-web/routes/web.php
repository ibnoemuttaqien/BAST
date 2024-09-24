<?php

use App\Models\User;
use App\Models\Barang;
use App\Models\LaporanHasil;
use App\Models\KategoriGrade;
use App\Models\KategoriPembuatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanHasilController;
use App\Http\Controllers\KategoriGradeController;
use App\Http\Controllers\KategoriPembuatanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $user = Auth::user();
        $totalUsers = User::count();
        $totalBarang = Barang::count();
        $totalKategoriPembuatan = KategoriPembuatan::count();
        $totalKategoriGrade = KategoriGrade::count();
        $totalLaporanHasil = LaporanHasil::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBarang',
            'totalKategoriPembuatan',
            'totalKategoriGrade',
            'totalLaporanHasil',
            'user'
        ));
    })->name('admin.dashboard');

    // Resource route for users, with 'admin' as the prefix
    Route::resource('admin/users', UserController::class, [
        'names' => [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ],
    ]);

    Route::resource('admin/kategori_pembuatan', KategoriPembuatanController::class, [
        'names' => [
            'index' => 'admin.kategori_pembuatan.index',
            'create' => 'admin.kategori_pembuatan.create',
            'store' => 'admin.kategori_pembuatan.store',
            'edit' => 'admin.kategori_pembuatan.edit',
            'update' => 'admin.kategori_pembuatan.update',
            'destroy' => 'admin.kategori_pembuatan.destroy',
        ],
    ]);

    Route::resource('admin/kategori_grade', KategoriGradeController::class, [
        'names' => [
            'index' => 'admin.kategori_grade.index',
            'create' => 'admin.kategori_grade.create',
            'store' => 'admin.kategori_grade.store',
            'edit' => 'admin.kategori_grade.edit',
            'update' => 'admin.kategori_grade.update',
            'destroy' => 'admin.kategori_grade.destroy',
        ],
    ]);

    Route::resource('admin/barang', BarangController::class, [
        'names' => [
            'index' => 'admin.barang.index',
            'create' => 'admin.barang.create',
            'store' => 'admin.barang.store',
            'edit' => 'admin.barang.edit',
            'update' => 'admin.barang.update',
            'destroy' => 'admin.barang.destroy',
        ],
    ]);

    Route::get('/admin/laporan-hasil', [AdminController::class, 'laporanHasil'])->name('admin.laporan_hasil');
    Route::get('/admin/print-laporan-hasil', [AdminController::class, 'printLaporanHasil'])->name('admin.print_laporan_hasil');
});

// Owner Routes
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', function () {
        $user = Auth::user();

        return view('owner.dashboard', compact('user'));
    })->name('owner.dashboard');
    Route::get('/owner/stok-barang', [OwnerController::class, 'stokBarang'])->name('owner.stok_barang');
    Route::get('/owner/stok_barang/print', [OwnerController::class, 'printStokBarang'])->name('owner.print_stok_barang');

    Route::get('/owner/laporan-hasil', [OwnerController::class, 'laporanHasil'])->name('owner.laporan_hasil');
    Route::get('/owner/print-laporan-hasil', [OwnerController::class, 'printLaporanHasil'])->name('owner.print_laporan_hasil');
    Route::get('/owner/laporan-hasil-karyawan', [OwnerController::class, 'laporanHasilByKaryawan'])->name('owner.laporan_hasil_by_karyawan');
    Route::get('owner/print-laporan-hasil-by-karyawan', [OwnerController::class, 'printLaporanHasilByKaryawan'])->name('owner.print_laporan_hasil_by_karyawan');
    Route::get('owner/absensi', [OwnerController::class, 'absensi'])->name('owner.absensi');
    Route::get('owner/print-absensi', [OwnerController::class, 'printAbsensi'])->name('owner.print_absensi');
});

// Karyawan Routes
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', function () {
        $user = Auth::user();

        return view('karyawan.dashboard', compact('user'));
    })->name('karyawan.dashboard');
    Route::resource('karyawan/absensi', AbsensiController::class, [
        'names' => [
            'index' => 'karyawan.absensi.index',
            'create' => 'karyawan.absensi.create',
            'store' => 'karyawan.absensi.store',
            'edit' => 'karyawan.absensi.edit',
            'update' => 'karyawan.absensi.update',
            'destroy' => 'karyawan.absensi.destroy',
        ],
    ]);
    Route::resource('karyawan/laporan_hasil', LaporanHasilController::class, [
        'names' => [
            'index' => 'karyawan.laporan_hasil.index',
            'create' => 'karyawan.laporan_hasil.create',
            'store' => 'karyawan.laporan_hasil.store',
            'edit' => 'karyawan.laporan_hasil.edit',
            'update' => 'karyawan.laporan_hasil.update',
            'destroy' => 'karyawan.laporan_hasil.destroy',
        ],
    ]);
    // Contoh route untuk edit
    Route::get('/karyawan/laporan_hasil/{id}/edit', [LaporanHasilController::class, 'edit'])->name('laporan_hasil.edit');
});
