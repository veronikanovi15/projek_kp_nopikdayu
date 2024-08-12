
@extends('master1.layout')

@section('judul','Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/kunjungan">Kunjungan</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection

@section('content')
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tambah Kunjungan</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
        
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <form method="POST" action="{{ route('kunjungan.store') }}" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                    <label for="tanggal_kunjungan" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" value="">
                    </div>
                </div>
              <div class="form-group row">
                  <label for="pengunjung" class="col-sm-2 col-form-label">Pengunjung</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="pengunjung" name="pengunjung" value="">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="kota_asal" class="col-sm-2 col-form-label">Kota Asal</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="kota_asal" name="kota_asal" value="">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="penerima" class="col-sm-2 col-form-label">Penerima</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="penerima" name="penerima" value="">
                  </div>
              </div>
              <div class="form-group row">
                    <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="gambar" name="gambar">
                    </div>
                </div>
              <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-success">Simpan</button>
                      <a href="{{ route('kunjungan.index') }}">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-left"></i> Batal
                            </button>
                        </a>
                  </div>
              </div>
          </form>
        </div>
        <!-- /.card-body -->
        <!--div class="card-footer">
          Footer
        </div -->
        <!-- /.card-footer-->
      </div>

@endsection