@extends ('master1.layout')

@section ('judul','Detail Data Akses')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('akses.index') }}">Pengelolaan Akses</a></li>
    <li class="breadcrumb-item active">Detail Data</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Data Akses</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <p id="nama">{{ $akses->nama }}</p>
            </div>

            <div class="form-group">
                <label for="url">URL:</label>
                <p id="url">{{ $akses->url }}</p>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <p id="username">{{ $akses->username }}</p>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <p id="password">{{ $akses->password }}</p>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <p id="keterangan">{{ $akses->keterangan }}</p>
            </div>

            <a href="{{ route('akses.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
