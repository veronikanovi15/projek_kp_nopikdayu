@extends('master1.layout')

@section('judul', 'Tambah Data Akses')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('akses.index') }}">Akses</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Akses</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('akses.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">NamaAkses</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" id="url" name="url" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="keterangan" class="form-control" id="keterangan" name="keterangan" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('akses.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
