<?php

namespace App\Http\Controllers;

use App\Models\KategoriGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriGradeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $kategoriGrade = KategoriGrade::all();
        return view('admin.kategori_grade.index', compact('kategoriGrade', 'user'));
    }

    public function create()
    {
        return view('admin.kategori_grade.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriGrade::create($request->only('nama'));

        return redirect()->route('admin.kategori_grade.index')
            ->with('success', 'Kategori Grade created successfully.');
    }

    public function show($id)
    {
        $kategoriGrade = KategoriGrade::findOrFail($id);
        return view('admin.kategori_grade.show', compact('kategoriGrade'));
    }

    public function edit($id)
    {
        $kategoriGrade = KategoriGrade::findOrFail($id);
        return view('admin.kategori_grade.edit', compact('kategoriGrade'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategoriGrade = KategoriGrade::findOrFail($id);
        $kategoriGrade->update($request->only('nama'));

        return redirect()->route('admin.kategori_grade.index')
            ->with('success', 'Kategori Grade updated successfully.');
    }

    public function destroy($id)
    {
        $kategoriGrade = KategoriGrade::findOrFail($id);
        $kategoriGrade->delete();

        return redirect()->route('admin.kategori_grade.index')
            ->with('success', 'Kategori Grade deleted successfully.');
    }
}
