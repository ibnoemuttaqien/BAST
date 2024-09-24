<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Stok Barang per Tanggal: {{ $tanggal ?: 'Semua' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Stok Barang per Tanggal: {{ $tanggal ?: 'Semua' }}</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Ukuran</th>
                <th>Kategori Pembuatan</th>
                <th>Kategori Grade</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->deskripsi }}</td>
                    <td>{{ $barang->ukuran }}</td>
                    <td>{{ $barang->kategoriPembuatan->nama ?? 'N/A' }}</td>
                    <td>{{ $barang->kategoriGrade->nama ?? 'N/A' }}</td>
                    <td>{{ $barang->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
