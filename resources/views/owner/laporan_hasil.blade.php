@extends('layouts.owner')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h1 class="m-0">Laporan Hasil</h1>
            <a href="{{ route('owner.print_laporan_hasil', ['tanggal_mulai' => $tanggalMulai, 'tanggal_akhir' => $tanggalAkhir, 'kategori_pembuatan_id' => request('kategori_pembuatan_id'), 'kategori_grade_id' => request('kategori_grade_id')]) }}"
                class="btn btn-secondary">Print PDF</a>
        </div>
        <hr>
        <!-- Filter Form -->
        <form action="{{ route('owner.laporan_hasil') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                        value="{{ $tanggalMulai }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                        value="{{ $tanggalAkhir }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="kategori_pembuatan_id" class="form-label">Kategori Pembuatan:</label>
                    <select name="kategori_pembuatan_id" id="kategori_pembuatan_id" class="form-control">
                        <option value="">Semua</option>
                        @foreach ($kategoriPembuatan as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ $kategori->id == request('kategori_pembuatan_id') ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="kategori_grade_id" class="form-label">Kategori Grade:</label>
                    <select name="kategori_grade_id" id="kategori_grade_id" class="form-control">
                        <option value="">Semua</option>
                        @foreach ($kategoriGrade as $grade)
                            <option value="{{ $grade->id }}"
                                {{ $grade->id == request('kategori_grade_id') ? 'selected' : '' }}>
                                {{ $grade->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('owner.laporan_hasil') }}" class="btn btn-secondary">Tampilkan Semua</a>
            </div>
        </form>

        <!-- Data Table -->
        @if ($laporanHasil->isEmpty())
            <div class="alert alert-info">Tidak ada laporan hasil yang tersedia.</div>
        @else
            <div class="table-responsive">
                <table id="table-ok" class="table table-striped table-bordered">
                    <thead class="thead-dark">
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
            </div>
        @endif
    </div>
@endsection
