@extends('master1.layout')

@section('judul', 'Pengelolaan User')

@section('breadcrumb')
    <li class="breadcrumb-item active">Pengelolaan User</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar User</h3>
            <div class="card-tools">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="fa fa-plus"></i> Tambah User
                </button>
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

    <!-- Modal Create User -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Show User -->
    <div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showUserModalLabel">Detail User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="showUserDetails"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editUserId">
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editPassword">Password</label>
                            <input type="password" name="password" id="editPassword" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role</label>
                            <select name="role" id="editRole" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete User -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Hapus User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user ini?</p>
                    <input type="hidden" id="deleteUserId">
                    <button id="confirmDelete" class="btn btn-danger">Hapus</button>
                </div>
            </div>
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function () {
    // Inisialisasi DataTable
    var table = $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('masteruser.getData') }}',
            type: 'GET'
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-info btn-sm show-user" data-id="${row.id}">Show</button>
                        <button class="btn btn-warning btn-sm edit-user" data-id="${row.id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-user" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Submit Create Form
    $('#createForm').on('submit', function (e) {
    e.preventDefault();
    console.log($(this).serialize()); // Cek data yang dikirim
    $.ajax({
        url: '{{ route('masteruser.store') }}',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            console.log(response); // Cek respons dari server
            if (response.success) {
                $('#createUserModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Berhasil!', 'User berhasil ditambahkan.', 'success');
            } else {
                Swal.fire('Gagal!', response.message, 'error');
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText); // Cek error dari server
            Swal.fire('Gagal!', 'Terjadi kesalahan saat menambahkan user.', 'error');
        }
    });
});


    // Show User
    $(document).on('click', '.show-user', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route('masteruser.show', '__ID__') }}'.replace('__ID__', id),
            type: 'GET',
            success: function (response) {
                if (response.error) {
                    Swal.fire('Error', response.error, 'error');
                    return;
                }

                $('#showUserDetails').html(`
                    <p><strong>Nama:</strong> ${response.name}</p>
                    <p><strong>Email:</strong> ${response.email}</p>
                    <p><strong>Role:</strong> ${response.role}</p>
                    <p><strong>Password:</strong> ${response.decryptedPassword}</p>
                `);
                $('#showUserModal').modal('show');
            },
            error: function () {
                Swal.fire('Gagal!', 'Terjadi kesalahan saat mengambil data user.', 'error');
            }
        });
    });

    // Edit User Modal
    $(document).on('click', '.edit-user', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url('masteruser') }}/' + id + '/edit',
            type: 'GET',
            success: function (response) {
                $('#editUserId').val(response.id);
                $('#editName').val(response.name);
                $('#editEmail').val(response.email);
                $('#editRole').val(response.role);
                $('#editUserModal').modal('show');
            }
        });
    });

    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        var id = $('#editUserId').val();
        $.ajax({
            url: '{{ url('masteruser') }}/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    $('#editUserModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Berhasil!', 'User berhasil diperbarui.', 'success');
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui user.', 'error');
            }
        });
    });

    // Delete User Modal
    $(document).on('click', '.delete-user', function () {
        var id = $(this).data('id');
        $('#deleteUserId').val(id);
        $('#deleteUserModal').modal('show');
    });

    $('#confirmDelete').on('click', function () {
        var id = $('#deleteUserId').val();
        $.ajax({
            url: '{{ url('masteruser') }}/' + id,
            type: 'DELETE',
            success: function (response) {
                if (response.success) {
                    $('#deleteUserModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Berhasil!', 'User berhasil dihapus.', 'success');
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus user.', 'error');
            }
        });
    });
});



        
    </script>
@endpush
