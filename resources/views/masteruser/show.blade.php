@extends('master1.layout')

@section('judul', 'Detail User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('masteruser.index') }}">Pengelolaan User</a></li>
    <li class="breadcrumb-item active">Detail User</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail User</h3>
    </div>
    <div class="card-body">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Peran:</strong> {{ $user->role }}</p>
        <p><strong>Dibuat pada:</strong> {{ $user->created_at->format('d-m-Y H:i:s') }}</p>
        <p><strong>Diubah pada:</strong> {{ $user->updated_at->format('d-m-Y H:i:s') }}</p>
        <p><strong>Password:</strong> {{ $decryptedPassword }}</p>
        
        <a href="{{ route('masteruser.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
