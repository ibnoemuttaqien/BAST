<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\LaporanHasil;
use App\Models\User;
use App\Models\KategoriGrade;
use App\Models\KategoriPembuatan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
  // Lihat Stok Barang Berdasarkan Tanggal
  public function stokBarang(Request $request)
  {
    $user = Auth::user();

    $tanggal = $request->input('tanggal');

    if ($tanggal) {
      $barangs = Barang::with(['kategoriPembuatan', 'kategoriGrade'])
        ->whereDate('created_at', $tanggal)
        ->orWhereDate('updated_at', $tanggal)
        ->get();
    } else {
      $barangs = Barang::with(['kategoriPembuatan', 'kategoriGrade'])->get();
    }

    return view('owner.stok_barang', compact('barangs', 'tanggal', 'user'));
  }


  public function printStokBarang(Request $request)
  {
    $tanggal = $request->input('tanggal');

    if ($tanggal) {
      $barangs = Barang::with(['kategoriPembuatan', 'kategoriGrade'])
        ->whereDate('created_at', $tanggal)
        ->orWhereDate('updated_at', $tanggal)
        ->get();
    } else {
      $barangs = Barang::with(['kategoriPembuatan', 'kategoriGrade'])->get();
    }

    $pdf = Pdf::loadView('owner.stok_barang_pdf', compact('barangs', 'tanggal'));
    return $pdf->download('stok_barang_' . ($tanggal ?: 'semua') . '.pdf');
  }



  // Lihat Laporan Hasil
  public function laporanHasil(Request $request)
  {
    $user = Auth::user();

    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');
    $kategoriPembuatanId = $request->input('kategori_pembuatan_id');
    $kategoriGradeId = $request->input('kategori_grade_id');

    $laporanHasilQuery = LaporanHasil::query()
      ->with(['barang', 'user']);

    if ($tanggalMulai && $tanggalAkhir) {
      $laporanHasilQuery->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
    }

    if ($kategoriPembuatanId) {
      $laporanHasilQuery->whereHas('barang', function ($query) use ($kategoriPembuatanId) {
        $query->where('kategori_pembuatan_id', $kategoriPembuatanId);
      });
    }

    if ($kategoriGradeId) {
      $laporanHasilQuery->whereHas('barang', function ($query) use ($kategoriGradeId) {
        $query->where('kategori_grade_id', $kategoriGradeId);
      });
    }

    $laporanHasil = $laporanHasilQuery->get();
    $kategoriPembuatan = KategoriPembuatan::all();
    $kategoriGrade = KategoriGrade::all();

    return view('owner.laporan_hasil', compact('user', 'laporanHasil', 'tanggalMulai', 'tanggalAkhir', 'kategoriPembuatan', 'kategoriGrade'));
  }

  public function printLaporanHasil(Request $request)
  {
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');
    $kategoriPembuatanId = $request->input('kategori_pembuatan_id');
    $kategoriGradeId = $request->input('kategori_grade_id');

    $laporanHasilQuery = LaporanHasil::query()
      ->with(['barang', 'user']);

    if ($tanggalMulai && $tanggalAkhir) {
      $laporanHasilQuery->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
    }

    if ($kategoriPembuatanId) {
      $laporanHasilQuery->whereHas('barang', function ($query) use ($kategoriPembuatanId) {
        $query->where('kategori_pembuatan_id', $kategoriPembuatanId);
      });
    }

    if ($kategoriGradeId) {
      $laporanHasilQuery->whereHas('barang', function ($query) use ($kategoriGradeId) {
        $query->where('kategori_grade_id', $kategoriGradeId);
      });
    }

    $laporanHasil = $laporanHasilQuery->get();
    $pdf = Pdf::loadView('pdf.laporan_hasil', compact('laporanHasil', 'tanggalMulai', 'tanggalAkhir'));
    return $pdf->download('laporan_hasil.pdf');
  }

  // Lihat Laporan Hasil Berdasarkan Pilihan Karyawan
  // Lihat Laporan Hasil Berdasarkan Pilihan Karyawan
  public function laporanHasilByKaryawan(Request $request)
  {
    $user = Auth::user();

    $karyawanId = $request->input('karyawan_id');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');

    $karyawans = User::where('role', 'karyawan')->get();

    $laporanHasilQuery = LaporanHasil::query()
      ->where('id_user', $karyawanId)
      ->with('barang');

    if ($tanggalMulai && $tanggalAkhir) {
      $laporanHasilQuery->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
    }

    $laporanHasil = $laporanHasilQuery->get();

    return view('owner.laporan_hasil_by_karyawan', compact('user', 'laporanHasil', 'karyawans', 'karyawanId', 'tanggalMulai', 'tanggalAkhir'));
  }

  public function printLaporanHasilByKaryawan(Request $request)
  {
    $karyawanId = $request->input('karyawan_id');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');

    $karyawans = User::where('role', 'karyawan')->get();

    $laporanHasilQuery = LaporanHasil::query()
      ->where('id_user', $karyawanId)
      ->with('barang');

    if ($tanggalMulai && $tanggalAkhir) {
      $laporanHasilQuery->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
    }

    $laporanHasil = $laporanHasilQuery->get();

    $pdf = Pdf::loadView('pdf.laporan_hasil_by_karyawan', [
      'laporanHasil' => $laporanHasil,
      'karyawans' => $karyawans,
      'karyawanId' => $karyawanId,
      'tanggalMulai' => $tanggalMulai,
      'tanggalAkhir' => $tanggalAkhir
    ]);

    return $pdf->download('laporan_hasil_by_karyawan.pdf');
  }

  // Lihat Absensi Berdasarkan Tanggal
  public function absensi(Request $request)
  {
    $user = Auth::user();

    $tanggal = $request->input('tanggal');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');
    $karyawanId = $request->input('karyawan_id');

    $absensiQuery = Absensi::query()->with('user');

    if ($tanggal) {
      $absensiQuery->whereDate('tanggal_masuk', $tanggal);
    }

    if ($tanggalMulai && $tanggalAkhir) {
      $absensiQuery->whereBetween('tanggal_masuk', [$tanggalMulai, $tanggalAkhir]);
    }

    if ($karyawanId) {
      $absensiQuery->where('id_user', $karyawanId);
    }

    $absensi = $absensiQuery->get();
    $karyawans = User::where('role', 'karyawan')->get();

    return view('owner.absensi', compact('user', 'absensi', 'tanggal', 'tanggalMulai', 'tanggalAkhir', 'karyawanId', 'karyawans'));
  }

  public function printAbsensi(Request $request)
  {
    $tanggal = $request->input('tanggal');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');
    $karyawanId = $request->input('karyawan_id');

    $absensiQuery = Absensi::query()->with('user');

    if ($tanggal) {
      $absensiQuery->whereDate('tanggal_masuk', $tanggal);
    }

    if ($tanggalMulai && $tanggalAkhir) {
      $absensiQuery->whereBetween('tanggal_masuk', [$tanggalMulai, $tanggalAkhir]);
    }

    if ($karyawanId) {
      $absensiQuery->where('id_user', $karyawanId);
    }

    $absensi = $absensiQuery->get();
    $pdf = Pdf::loadView('pdf.absensi', compact('absensi', 'tanggal', 'tanggalMulai', 'tanggalAkhir', 'karyawanId'));
    return $pdf->download('absensi_' . ($tanggal ?: 'semua') . '.pdf');
  }
}
