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
                <h4>Welcome, {{ Auth::user()->name }}!</h4>
                <!-- Jika kamu ingin menampilkan informasi pengguna lebih lanjut, tambahkan di sini -->
            </div>
        </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>E-Surat</h3>
                        <p>jskajs</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Info Lebih Lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Agenda</h3>
                        <p>acara yang akan berlangsung</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Info Lebih Lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-dark">
                    <div class="inner">
                        <h3>TTE</h3>
                        <p>dssfdsfsd</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Info Lebih Lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
