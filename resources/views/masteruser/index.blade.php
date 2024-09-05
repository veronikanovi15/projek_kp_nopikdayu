

@extends('master1.layout')

@section('judul', 'Pengelolaan User')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pengelolaan User</li>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Pencarian Data User</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('masteruser.index') }}">
                <div class="form-group">
                    <label for="search">Cari Data:</label>
                    <input type="text" name="search" class="form-control" id="search" placeholder="Masukkan kata kunci pencarian" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Cari
                </button>
                <a href="{{ route('masteruser.index') }}" class="btn btn-secondary">
                    <i class="fa fa-times"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar User</h3>
            <div class="card-tools">
                <a href="{{ route('masteruser.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah User
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="userTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan diisi oleh DataTables -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('masteruser.data') }}',
                    type: 'GET',
                    data: function (d) {
                        d.search = $('#search').val(); // Pass the search input value
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Add event listener for delete buttons
            $('#userTable').on('click', '.delete-user', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                table.ajax.reload(); // Reload table data
                                Swal.fire(
                                    'Terhapus!',
                                    'User telah dihapus.',
                                    'success'
                                );
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus user.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
