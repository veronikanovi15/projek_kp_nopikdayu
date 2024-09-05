

@extends('master1.layout')

@section('judul', 'Tambah User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('masteruser.index') }}">Pengelolaan User</a></li>
    <li class="breadcrumb-item active">Tambah User</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah User</h3>
    </div>
    <div class="card-body">
        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="userForm" method="POST" action="{{ route('masteruser.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <label for="is_admin">Admin?</label>
                <select class="form-control" id="is_admin" name="is_admin">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('masteruser.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
