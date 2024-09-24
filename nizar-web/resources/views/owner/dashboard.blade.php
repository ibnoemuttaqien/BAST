@extends('layouts.owner')

@section('content')
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Welcome Message -->
        <div class="alert alert-dark">
            <h4><i class="icon fas fa-info"></i> Selamat Datang, {{ Auth::user()->nama }}!</h4>
            <p>Semoga hari Anda menyenangkan!</p>
        </div>

        <!-- Dashboard Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><a href="{{ route('owner.stok_barang') }}" class="text-white">Stok Barang</a></h3>
                        <p>Jumlah Barang</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <a href="{{ route('owner.stok_barang') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-white text-dark">
                    <div class="inner">
                        <h3><a href="{{ route('owner.laporan_hasil') }}" class="text-dark">Laporan Hasil</a></h3>
                        <p>Hasil Laporan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('owner.laporan_hasil') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger text-white">
                    <div class="inner">
                        <h3><a href="{{ route('owner.laporan_hasil_by_karyawan') }}" class="text-white">Laporan Hasil
                            </a></h3>
                        <p>Laporan Berdasarkan Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('owner.laporan_hasil_by_karyawan') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light text-dark">
                    <div class="inner">
                        <h3><a href="{{ route('owner.absensi') }}" class="text-dark">Laporan Absensi</a></h3>
                        <p>Absensi Harian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="{{ route('owner.absensi') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
