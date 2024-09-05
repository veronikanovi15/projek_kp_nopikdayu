

@extends('master1.layout')

@section('judul', 'Edit User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('masteruser.index') }}">Pengelolaan User</a></li>
    <li class="breadcrumb-item active">Edit User</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <div class="card-body">
            <form id="updateForm" action="{{ route('masteruser.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#updateForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form submit secara default

                var url = $(this).attr('action');
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: $(this).serialize(), // Mengirimkan data form yang telah di-serialize
                    success: function(response) {
                        Swal.fire(
                            'Berhasil!',
                            'User telah diperbarui.',
                            'success'
                        ).then(() => {
                            window.location.href = '{{ route("masteruser.index") }}'; // Arahkan ke halaman utama masteruser
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat memperbarui user.',
                            'error'
                        );
                    }
                });
            });
        });
    </script>
@endpush
