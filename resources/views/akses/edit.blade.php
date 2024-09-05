@extends ('master1.layout')

@section ('judul','Edit Data Akses')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('akses.index') }}">Pengelolaan Akses</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Data Akses</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Menampilkan pesan error jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('akses.update', $akses->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $akses->nama) }}" required>
                </div>

                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" id="url" name="url" value="{{ old('url', $akses->url) }}" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $akses->username) }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password', $akses->password) }}" required>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="keterangan" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan', $akses->keterangan) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('akses.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
