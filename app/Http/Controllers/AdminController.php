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

class AdminController extends Controller
{




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

    return view('admin.laporan_hasil', compact('laporanHasil', 'user', 'tanggalMulai', 'tanggalAkhir', 'kategoriPembuatan', 'kategoriGrade'));
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
}
