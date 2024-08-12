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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kunjungan</h3>

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
