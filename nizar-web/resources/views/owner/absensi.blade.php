@extends('layouts.owner')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h1 class="m-0">Laporan Absensi</h1>
            <a href="{{ route('owner.print_absensi', ['tanggal' => $tanggal, 'tanggal_mulai' => $tanggalMulai, 'tanggal_akhir' => $tanggalAkhir, 'karyawan_id' => $karyawanId]) }}"
                class="btn btn-secondary">Print PDF</a>
        </div>
        <hr>
        <!-- Filter Form -->
        <form action="{{ route('owner.absensi') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="tanggal" class="form-label">Tanggal:</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $tanggal }}">
                </div>
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
                    <label for="karyawan_id" class="form-label">Karyawan:</label>
                    <select name="karyawan_id" id="karyawan_id" class="form-control">
                        <option value="">Semua</option>
                        @foreach ($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}" {{ $karyawan->id == $karyawanId ? 'selected' : '' }}>
                                {{ $karyawan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('owner.absensi') }}" class="btn btn-secondary">Tampilkan Semua</a>
            </div>
        </form>

        <!-- Data Table -->
        @if ($absensi->isEmpty())
            <div class="alert alert-info">Tidak ada absensi untuk filter ini.</div>
        @else
            <div class="table-responsive">
                <table id="table-ok" class="table table-striped table-bordered">
                    <thead class="thead-dark">
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
            </div>
        @endif
    </div>
@endsection
