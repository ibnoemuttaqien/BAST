@extends('layouts.admin')

@section('content')
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
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #ff4c4c; color: #ffffff;">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer" style="color: #ffffff;">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #ffffff; color: #000000;">
                <div class="inner">
                    <h3>{{ $totalBarang }}</h3>
                    <p>Total Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('admin.barang.index') }}" class="small-box-footer" style="color: #000000;">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #ff4c4c; color: #ffffff;">
                <div class="inner">
                    <h3>{{ $totalKategoriPembuatan }}</h3>
                    <p>Total Kategori Pembuatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <a href="{{ route('admin.kategori_pembuatan.index') }}" class="small-box-footer"
                    style="color: #ffffff;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #ffffff; color: #000000;">
                <div class="inner">
                    <h3>{{ $totalKategoriGrade }}</h3>
                    <p>Total Kategori Grade</p>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <a href="{{ route('admin.kategori_grade.index') }}" class="small-box-footer" style="color: #000000;">More
                    info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #ffffff; color: #000000;">
                <div class="inner">
                    <h3>{{ $totalLaporanHasil }}</h3>
                    <p>Total Laporan Hasil</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('admin.laporan_hasil') }}" class="small-box-footer" style="color: #000000;">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
