<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .filters {
            margin-bottom: 20px;
        }

        .filters p {
            margin: 0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Hasil</h1>

        @if ($tanggalMulai && $tanggalAkhir)
            <div class="filters">
                <p>Periode: {{ $tanggalMulai }} - {{ $tanggalAkhir }}</p>
            </div>
        @endif

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
    </div>
</body>

</html>
