<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Barang;
use App\Models\KategoriGrade;
use App\Models\KategoriPembuatan;
use App\Models\User;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // Tampilkan semua tugas
    public function index()
    {
        $barang = Barang::all();
        $kategoriGrade = KategoriGrade::all();
        $kategoriPembuatan = KategoriPembuatan::all();
        $karyawans = User::where('role', 'karyawan')->get();
        $tugas = Tugas::with(['admin', 'karyawan', 'barang'])->get();
        return view('admin.tugas.index', compact('tugas', 'barang', 'karyawans', 'kategoriGrade', 'kategoriPembuatan'));
    }

    // Tampilkan form untuk membuat tugas
    public function create()
    {
        // Mendapatkan semua barang dan karyawan yang bisa dipilih
        $barangs = Barang::all();
        $karyawans = User::where('role', 'karyawan')->get(); // Mengambil user dengan role karyawan
        return view('admin.tugas.create', compact('barangs', 'karyawans'));
    }

    // Simpan tugas baru
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'barang_id' => 'required',
            'kategori_pembuatan_id' => 'required',
            'kategori_grade_id' => 'required',
            'karyawan_id' => 'required',
            'ukuran' => 'required',
            'warna' => 'required',
            'jumlah' => 'required|integer',
        ]);

        // Simpan tugas baru
        Tugas::create([
            'admin_id' => auth()->user()->id, // Admin yang login
            'barang_id' => $request->barang_id,
            'kategori_pembuatan_id' => $request->kategori_pembuatan_id,
            'kategori_grade_id' => $request->kategori_grade_id,
            'karyawan_id' => $request->karyawan_id, // Menyimpan ID karyawan yang dipilih
            'ukuran' => $request->ukuran,
            'warna' => $request->warna,
            'jumlah' => $request->jumlah,
            'status' => 'pending', // Status default ketika tugas dibuat
        ]);

        return redirect()->route('admin.tugas.index')->with('success', 'Tugas berhasil dibuat.');
    }

    // Tampilkan form untuk mengedit tugas
    public function edit(Tugas $tugas)
    {
        // Mendapatkan semua barang dan karyawan yang bisa dipilih
        $barangs = Barang::all();
        $karyawans = User::where('role', 'karyawan')->get(); // Mengambil user dengan role karyawan
        return view('admin.tugas.edit', compact('tugas', 'barangs', 'karyawans'));
    }

    // Update tugas yang ada
    public function update(Request $request, Tugas $tugas)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'barang_id' => 'required',
            'kategori_pembuatan_id' => 'required',
            'kategori_grade_id' => 'required',
            'karyawan_id' => 'required',
            'ukuran' => 'required',
            'warna' => 'required',
            'jumlah' => 'required|integer',
        ]);

        // Update tugas yang ada
        $tugas->update([
            'barang_id' => $request->barang_id,
            'kategori_pembuatan_id' => $request->kategori_pembuatan_id,
            'kategori_grade_id' => $request->kategori_grade_id,
            'karyawan_id' => $request->karyawan_id, // Mengupdate ID karyawan yang dipilih
            'ukuran' => $request->ukuran,
            'warna' => $request->warna,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Hapus tugas
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    // Karyawan mengubah status tugas
    public function updateStatus(Request $request, Tugas $tugas)
    {
        $tugas->update([
            'status' => 'selesai',
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diselesaikan.');
    }
}
