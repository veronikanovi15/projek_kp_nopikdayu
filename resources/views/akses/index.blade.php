@extends('master1.layout')

@section('judul', 'Pengelolaan Akses')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Pengelolaan Akses</a></li>
@endsection

@section('content')
    <!-- Search Data Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Pencarian Data Akses</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('akses.index') }}">
                <div class="form-group">
                    <label for="search">Cari Data:</label>
                    <input type="text" name="search" class="form-control" id="search" placeholder="Masukkan kata kunci pencarian" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengelolaan Akses</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>URL</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($akses as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->url }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->password }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <form method="POST" action="{{ route('akses.destroy', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('akses.edit', $item->id) }}" class="btn btn-warning">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin dihapus?');">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                    <a href="{{ route('akses.show', $item->id) }}" class="btn btn-primary">
                                        <i class="fa fa-info"></i> Show
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('akses.create') }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Data
                </button>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 5000
                });
            @endif
        });
    </script>
@endpush
