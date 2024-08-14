@extends ('master1.layout')

@section ('judul','Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Kunjungan</a></li>
    <!--li class="breadcrumb-item active"></li -->
@endsection
@section('content')
    <!-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif -->
    <!-- Filter Form -->
    <!-- Filter Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Laporan Kunjungan</h3>
        </div>

        <div class="card-body">
        <form action="{{ route('kunjungan.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <label for="start_date" class="mr-2">Tanggal Mulai:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group mr-2">
                <label for="end_date" class="mr-2">Tanggal Akhir:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('kunjungan.index') }}" class="btn btn-secondary">Reset Filter</a>
        </form>
    </div>
    </div>
    
    <!--tabel-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kunjungan</h3>

            <div class="card-tools">
                <form action="{{ route('kunjungan.index') }}" method="GET">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control float-right" placeholder="Cari Tanggal/Bulan" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Pengunjung</th>
                        <th>Kota Asal</th>
                        <th>Penerima Kominfo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $kunjungans as $kunjungan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d-m-Y') }}</td>
                            <td>{{ $kunjungan->pengunjung }}</td>
                            <td>{{ $kunjungan->kota_asal }}</td>
                            <td>{{ $kunjungan->penerima }}</td>
                            <td>
                                <form method="POST" action="{{ route('kunjungan.destroy', $kunjungan->kun_id) }}">
                                    @csrf 
                                    @method('DELETE')
                                    <a href="{{ route('kunjungan.edit' , $kunjungan->kun_id) }}">
                                        <button type="button" class="btn btn-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </a>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin dihapus?'); ">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                    <a href="{{ route('kunjungan.show' , $kunjungan->kun_id) }}">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-info"></i> Show
                                        </button>
                                    </a>
                                </form>
                                    
                            </td>
                        </tr>
                @endforeach
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <a href="{{ route('kunjungan.create') }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Data
                </button>
            </a>
            <a href="{{ route('kunjungan.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-print"></i> Cetak Laporan
                </button>
            </a>
        </div>
        <!-- /.card-footer-->
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
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
