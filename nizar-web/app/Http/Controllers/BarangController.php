<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriPembuatan;
use App\Models\KategoriGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BarangController extends Controller
{
    // Tampilkan daftar barang
    public function index()
    {
        $user = Auth::user();
        $kategoriPembuatan = KategoriPembuatan::all();
        $kategoriGrade = KategoriGrade::all();
        $barangs = Barang::with(['kategoriPembuatan', 'kategoriGrade'])->get();
        return view('admin.barang.index', compact('barangs', 'kategoriPembuatan', 'kategoriGrade', 'user'));
    }

    // Tampilkan form untuk membuat barang baru
    public function create()
    {
        $kategoriPembuatan = KategoriPembuatan::all();
        $kategoriGrade = KategoriGrade::all();
        return view('admin.barang.create', compact('kategoriPembuatan', 'kategoriGrade'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ukuran' => 'nullable|string',
            'kategori_pembuatan_id' => 'required|exists:kategori_pembuatan,id',
            'kategori_grade_id' => 'required|exists:kategori_grade,id',
            'stok' => 'required|integer',
        ]);

        Barang::create($request->all());
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Tampilkan form untuk mengedit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoriPembuatan = KategoriPembuatan::all();
        $kategoriGrade = KategoriGrade::all();
        return view('admin.barang.edit', compact('barang', 'kategoriPembuatan', 'kategoriGrade'));
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ukuran' => 'nullable|string',
            'kategori_pembuatan_id' => 'required|exists:kategori_pembuatan,id',
            'kategori_grade_id' => 'required|exists:kategori_grade,id',
            'stok' => 'required|integer',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
