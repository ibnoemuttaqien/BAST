<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil tanggal filter dari request, defaultnya adalah null
        $filterDate = $request->input('filter_date');

        // Mengambil absensi yang sesuai dengan pengguna yang login
        $absensisQuery = Absensi::where('id_user', Auth::id());

        // Jika ada tanggal filter, tambahkan kondisi pada query
        if ($filterDate) {
            $absensisQuery->whereDate('created_at', $filterDate);
        }

        $absensis = $absensisQuery->get();

        return view('karyawan.absensi.index', compact('absensis', 'user'));
    }


    // Tampilkan halaman create absensi
    public function create()
    {
        $user = Auth::user();

        return view('karyawan.absensi.create', compact('user'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kehadiran' => 'required',
            'foto' => 'nullable',
            'file' => 'nullable|file',
            'deskripsi' => 'nullable|string',
        ]);

        // Ambil ID pengguna dari sesi atau parameter lain
        $userId = auth()->id();

        // Periksa apakah ada absensi yang sudah dibuat untuk hari ini
        $today = now()->format('Y-m-d'); // Format tanggal saat ini
        $existingAbsensi = Absensi::where('id_user', $userId)
            ->whereDate('created_at', $today)
            ->first();

        if ($existingAbsensi) {
            return redirect()->route('karyawan.absensi.index')->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // Handle foto
        if ($request->has('foto')) {
            $fotoData = $request->input('foto');
            $fotoName = 'foto_' . time() . '.png';
            $fotoPath = public_path('absensi/' . $fotoName);
            file_put_contents($fotoPath, base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $fotoData)));
        } else {
            $fotoName = null;
        }

        // Buat entri absensi
        $absensi = new Absensi();
        $absensi->id_user = $userId;
        $absensi->kehadiran = $request->input('kehadiran');
        $absensi->foto = $fotoName;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('absensi_files');
            $file->move($filePath, $fileName);
            $absensi->file = 'absensi_files/' . $fileName;
        }

        $absensi->deskripsi = $request->input('deskripsi');
        $absensi->save();

        return redirect()->route('karyawan.absensi.index')->with('success', 'Absensi created successfully');
    }


    // Tampilkan halaman edit absensi
    public function edit($id)
    {
        $user = Auth::user();

        $absensi = Absensi::findOrFail($id);
        return view('karyawan.absensi.edit', compact('absensi', 'user'));
    }



    public function update(Request $request, $id)
    {
        // Find the absensi record or fail
        $absensi = Absensi::findOrFail($id);

        // Ensure the user has access to update
        if ($absensi->id_user !== auth()->id()) {
            return redirect()->route('karyawan.absensi.index')->with('error', 'You are not authorized to update this absensi.');
        }

        // Validate the request
        $request->validate([
            'kehadiran' => 'required',
            'foto' => 'nullable',
            'file' => 'nullable|file',
            'deskripsi' => 'nullable|string',
        ]);

        // Handle photo
        if ($request->has('foto')) {
            $fotoData = $request->input('foto');
            $fotoName = 'foto_' . time() . '.png';
            $fotoPath = public_path('absensi/' . $fotoName);
            file_put_contents($fotoPath, base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $fotoData)));

            // Delete old photo
            if ($absensi->foto) {
                $oldFotoPath = public_path('absensi/' . $absensi->foto);
                if (file_exists($oldFotoPath)) {
                    unlink($oldFotoPath);
                }
            }

            $absensi->foto = $fotoName;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('absensi_files');
            $file->move($filePath, $fileName);

            // Delete old file
            if ($absensi->file) {
                $oldFilePath = public_path($absensi->file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $absensi->file = 'absensi_files/' . $fileName;
        }

        // Update the remaining fields
        $absensi->kehadiran = $request->input('kehadiran');
        $absensi->deskripsi = $request->input('deskripsi');
        $absensi->save();

        return redirect()->route('karyawan.absensi.index')->with('success', 'Absensi updated successfully');
    }

    public function destroy($id)
    {
        // Find the Absensi record by ID or fail if not found
        $absensi = Absensi::findOrFail($id);

        // Ensure the authenticated user has permission to delete
        if ($absensi->id_user !== auth()->id()) {
            return redirect()->route('karyawan.absensi.index')->with('error', 'You are not authorized to delete this absensi.');
        }

        // Delete the associated files if they exist
        if ($absensi->foto) {
            $fotoPath = public_path('absensi/' . $absensi->foto);
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        if ($absensi->file) {
            $filePath = public_path($absensi->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete the Absensi record
        $absensi->delete();

        return redirect()->route('karyawan.absensi.index')->with('success', 'Absensi deleted successfully');
    }
}
