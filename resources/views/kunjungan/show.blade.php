@extends('master1.layout')

@section('judul','Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/kunjungan">Kunjungan</a></li>
    <li class="breadcrumb-item active">Detail Data</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Kunjungan</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group row">
                <label for="tanggal_kunjungan" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                <div class="col-sm-10">
                    <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label for="pengunjung" class="col-sm-2 col-form-label">Pengunjung</label>
                <div class="col-sm-10">
                    <p class="form-control-plaintext">{{ $kunjungan->pengunjung }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label for="kota_asal" class="col-sm-2 col-form-label">Kota Asal</label>
                <div class="col-sm-10">
                    <p class="form-control-plaintext">{{ $kunjungan->kota_asal }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label for="penerima" class="col-sm-2 col-form-label">Penerima</label>
                <div class="col-sm-10">
                    <p class="form-control-plaintext">{{ $kunjungan->penerima }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-10">
                    @if($kunjungan->gambar && $kunjungan->gambar !== '-')
                        <img src="{{ asset('images/'.$kunjungan->gambar) }}" alt="Gambar Kunjungan" class="img-fluid">
                    @else
                        <img src="{{ asset('defimage/default-image.jpg') }}" alt="Gambar Default" class="img-fluid">
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <a href="{{ route('kunjungan.index') }}">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
