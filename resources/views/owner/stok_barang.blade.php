@extends('layouts.owner')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h1 class="m-0">Laporan Stok Barang per Tanggal: {{ $tanggal ?: 'Semua' }}</h1>
            <a href="{{ route('owner.print_stok_barang', ['tanggal' => $tanggal]) }}" class="btn btn-secondary">Print PDF</a>
        </div>
        <hr>
        <!-- Filter Form -->
        <form action="{{ route('owner.stok_barang') }}" method="GET" class="mb-4">
            <div class="form-group row">
                <label for="tanggal" class="col-sm-2 col-form-label">Pilih Tanggal:</label>
                <div class="col-sm-4">
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $tanggal }}">
                </div>
                <div class="col-sm-6 d-flex align-items-center">
                    <button type="submit" class="btn btn-primary me-2 mr-2">Filter</button>
                    <a href="{{ route('owner.stok_barang') }}" class="btn btn-secondary">Tampilkan Semua</a>
                </div>
            </div>
        </form>

        <!-- Data Table -->
        @if ($barangs->isEmpty())
            <div class="alert alert-info">Tidak ada stok barang untuk tanggal ini.</div>
        @else
            <div class="table-responsive">
                <table id="table-ok" class="table table-striped table-bordered">
                    <thead class="thead-dark">
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
            </div>
        @endif
    </div>
@endsection
