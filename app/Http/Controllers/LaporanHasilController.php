<?php

namespace App\Http\Controllers;

use App\Models\LaporanHasil;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanHasilController extends Controller
{
    // Display a listing of the laporan_hasil.
    public function index(Request $request)
    {
        $barangs = Barang::with(['kategoriPembuatan', 'kategoriGrade'])->get();
        $user = Auth::user();

        // Default to current user's laporan hasil
        $laporanHasils = LaporanHasil::where('id_user', Auth::id());

        // Apply date filters if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $laporanHasils->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Get the filtered data
        $laporanHasils = $laporanHasils->get();

        return view('karyawan.laporan_hasil.index', compact('laporanHasils', 'barangs', 'user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf|max:15000',
        ]);

        $userId = Auth::id();

        $laporanHasil = new LaporanHasil();
        $laporanHasil->id_user = $userId;
        $laporanHasil->id_barang = $request->input('id_barang');
        $laporanHasil->deskripsi = $request->input('deskripsi');

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
            $filePath = public_path('laporan_files'); // Get the path to store the file

            // Create the directory if it doesn't exist
            if (!file_exists($filePath)) {
                mkdir($filePath, 0777, true);
            }

            // Move the file to the designated directory
            $file->move($filePath, $fileName);

            // Store the file path relative to the public directory
            $laporanHasil->file = 'laporan_files/' . $fileName;
        }

        $laporanHasil->save();

        return redirect()->route('karyawan.laporan_hasil.index')->with('success', 'Laporan hasil created successfully');
    }

    public function edit($id)
    {

        $laporanHasil = LaporanHasil::with(['barang.kategoriPembuatan', 'barang.kategoriGrade'])->findOrFail($id);
        $barangs = Barang::with(['kategoriPembuatan', 'kategoriGrade'])->get();
        $fileUrl = asset($laporanHasil->file); // Gunakan asset() untuk mendapatkan URL yang benar
        return response()->json([
            'laporanHasil' => $laporanHasil,
            'barangs' => $barangs,
            'fileUrl' => $fileUrl,
        ]);
    }
    public function update(Request $request, $id)
    {
        $laporanHasil = LaporanHasil::findOrFail($id);

        if ($laporanHasil->id_user !== auth()->id()) {
            return redirect()->route('karyawan.laporan_hasil.index')->with('error', 'You are not authorized to update this laporan hasil.');
        }

        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf|max:15000',
        ]);

        $laporanHasil->id_barang = $request->input('id_barang');
        $laporanHasil->deskripsi = $request->input('deskripsi');

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if it exists
            if ($laporanHasil->file) {
                $oldFilePath = public_path($laporanHasil->file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Store new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
            $filePath = public_path('laporan_files'); // Get the path to store the file

            // Create the directory if it doesn't exist
            if (!file_exists($filePath)) {
                mkdir($filePath, 0777, true);
            }

            // Move the file to the designated directory
            $file->move($filePath, $fileName);

            // Store the new file path relative to the public directory
            $laporanHasil->file = 'laporan_files/' . $fileName;
        }

        $laporanHasil->save();

        return redirect()->route('karyawan.laporan_hasil.index')->with('success', 'Laporan hasil updated successfully');
    }

    public function destroy($id)
    {
        $laporanHasil = LaporanHasil::findOrFail($id);

        if ($laporanHasil->id_user !== auth()->id()) {
            return redirect()->route('karyawan.laporan_hasil.index')->with('error', 'You are not authorized to delete this laporan hasil.');
        }

        // Delete associated file if it exists
        if ($laporanHasil->file) {
            $filePath = public_path($laporanHasil->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete the laporanHasil record
        $laporanHasil->delete();

        return redirect()->route('karyawan.laporan_hasil.index')->with('success', 'Laporan hasil deleted successfully');
    }
}
