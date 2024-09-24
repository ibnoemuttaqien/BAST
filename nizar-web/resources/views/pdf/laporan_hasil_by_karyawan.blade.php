<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan Hasil Berdasarkan Karyawan</h1>

    <p>Karyawan: {{ $karyawanId ? $karyawans->firstWhere('id', $karyawanId)->nama : 'Semua' }}</p>
    <p>Periode: {{ $tanggalMulai ? $tanggalMulai : 'Semua' }} - {{ $tanggalAkhir ? $tanggalAkhir : 'Semua' }}</p>

    @if ($laporanHasil->isEmpty())
        <p>Tidak ada laporan hasil yang tersedia.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Kategori Pembuatan</th>
                    <th>Grade</th>
                    <th>Nama Pengguna</th>
                    <th>File</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanHasil as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->barang->nama }}</td>
                        <td>{{ $laporan->deskripsi }}</td>
                        <td>{{ $laporan->barang->kategoriPembuatan->nama ?? 'N/A' }}</td>
                        <td>{{ $laporan->barang->kategoriGrade->nama ?? 'N/A' }}</td>
                        <td>{{ $laporan->user->nama ?? 'N/A' }}</td>
                        <td>
                            @if ($laporan->file)
                                <a href="{{ asset($laporan->file) }}" target="_blank">View File</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $laporan->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
