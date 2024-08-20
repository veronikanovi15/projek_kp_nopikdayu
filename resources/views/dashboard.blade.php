@extends('master1.layout')

@section('judul', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Menampilkan nama pengguna yang sedang login -->
    <div class="row mb-4">
        <div class="col">
            <h4>Selamat datang, {{ Auth::user()->name }}!</h4>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Data Akses</h3>
                        <h4>{{ $aksesCount }}</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="/akses" class="small-box-footer">Info Lebih Lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Data Kunjungan</h3>
                        <h4>{{ $kunjunganCount }}</h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="/kunjungan" class="small-box-footer">Info Lebih Lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
