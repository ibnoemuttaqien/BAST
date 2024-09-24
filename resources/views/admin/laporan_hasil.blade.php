@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1>Laporan Hasil</h1>
        <hr>
        <form action="{{ route('admin.laporan_hasil') }}" method="GET" class="mb-4">
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                            value="{{ $tanggalMulai }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir:</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                            value="{{ $tanggalAkhir }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="kategori_pembuatan_id">Kategori Pembuatan:</label>
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
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="kategori_grade_id">Kategori Grade:</label>
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
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('admin.laporan_hasil') }}" class="btn btn-secondary me-2">Tampilkan Semua</a>
                <a href="{{ route('admin.print_laporan_hasil', ['tanggal_mulai' => $tanggalMulai, 'tanggal_akhir' => $tanggalAkhir, 'kategori_pembuatan_id' => request('kategori_pembuatan_id'), 'kategori_grade_id' => request('kategori_grade_id')]) }}"
                    class="btn btn-secondary">
                    <i class="fas fa-file-pdf"></i> Print PDF
                </a>
            </div>
        </form>

        @if ($laporanHasil->isEmpty())
            <p>Tidak ada laporan hasil yang tersedia.</p>
        @else
            <div class="table-responsive">
                <table id="table-ok" class="table table-bordered table-striped">
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
