<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
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
    <h1>Laporan Absensi</h1>
    <p>Karyawan: {{ $karyawanId ? $karyawanId : 'Semua' }}</p>
    <p>Periode: {{ $tanggal ? $tanggal : ($tanggalMulai ? $tanggalMulai . ' - ' . $tanggalAkhir : 'Semua') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Foto</th>
                <th>Kehadiran</th>
                <th>Tanggal Masuk</th>
                <th>File</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>
                        @if ($item->foto)
                            <img src="{{ asset('absensi/' . $item->foto) }}" alt="Foto" width="100">
                            <a href="{{ asset('absensi/' . $item->foto) }}" target="_blank">Lihat
                                Foto</a>
                        @else
                            N/A
                        @endif
                    </td>

                    <td>{{ $item->kehadiran }}</td>
                    <td>{{ $item->tanggal_masuk->format('d-m-Y H:i:s') }}</td>
                    <td>
                        @if ($item->file)
                            <a href="{{ asset($item->file) }}" target="_blank">Lihat File</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
