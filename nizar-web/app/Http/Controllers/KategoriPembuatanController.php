<?php

namespace App\Http\Controllers;

use App\Models\KategoriPembuatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriPembuatanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $kategoriPembuatan = KategoriPembuatan::all();
        return view('admin.kategori_pembuatan.index', compact('kategoriPembuatan', 'user'));
    }

    public function create()
    {
        return view('admin.kategori_pembuatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriPembuatan::create($request->only('nama'));

        return redirect()->route('admin.kategori_pembuatan.index')
            ->with('success', 'Kategori Pembuatan created successfully.');
    }

    public function show($id)
    {
        $kategoriPembuatan = KategoriPembuatan::findOrFail($id);
        return view('admin.kategori_pembuatan.show', compact('kategoriPembuatan'));
    }

    public function edit($id)
    {
        $kategoriPembuatan = KategoriPembuatan::findOrFail($id);
        return view('admin.kategori_pembuatan.edit', compact('kategoriPembuatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategoriPembuatan = KategoriPembuatan::findOrFail($id);
        $kategoriPembuatan->update($request->only('nama'));

        return redirect()->route('admin.kategori_pembuatan.index')
            ->with('success', 'Kategori Pembuatan updated successfully.');
    }

    public function destroy($id)
    {
        $kategoriPembuatan = KategoriPembuatan::findOrFail($id);
        $kategoriPembuatan->delete();

        return redirect()->route('admin.kategori_pembuatan.index')
            ->with('success', 'Kategori Pembuatan deleted successfully.');
    }
}
