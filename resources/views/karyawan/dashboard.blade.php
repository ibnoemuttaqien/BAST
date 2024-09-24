@extends('layouts.karyawan')

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
            <div class="col-lg-6 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><a href="{{ route('karyawan.absensi.index') }}" class="text-white">Absensi </a>
                        </h3>
                        <p>Absensi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="{{ route('karyawan.absensi.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-6">
                <!-- small box -->
                <div class="small-box bg-white text-dark">
                    <div class="inner">
                        <h3><a href="{{ route('karyawan.laporan_hasil.index') }}" class="text-dark">Laporan Hasil</a>
                        </h3>
                        <p>Laporan Hasil</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('karyawan.laporan_hasil.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
