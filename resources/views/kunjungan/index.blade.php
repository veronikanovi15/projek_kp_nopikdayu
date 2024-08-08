@extends ('master1.layout')

@section ('judul','Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Kunjungan</a></li>
    <!--li class="breadcrumb-item active"></li -->
@endsection
@section('content')
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
                <tr>
                    <th>No</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Pengunjung</th>
                    <th>Kota Asal</th>
                    <th>Penerima Kominfo</th>
                    <th>Aksi</th>
                </tr>

                <tr>
                    <td>No</td>
                    <td>Tanggal Kunjungan</td>
                    <td>Pengunjung</td>
                    <td>Kota Asal</td>
                    <td>Penerima Kominfo</td>
                    <td>
                        <form method="POST" action="">
                            @csrf 
                            @method('DELETE')
                            <a href="">
                                <button type="button" class="btn btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                            </a>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin dihapus?'); ">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                            <a href="">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-info"></i> Show
                                </button>
                            </a>
                        </form>
                            
                    </td>
                </tr>
                
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <a href="">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Data
                </button>
            </a>
        </div>
        <!-- /.card-footer-->
    </div>
@endsection