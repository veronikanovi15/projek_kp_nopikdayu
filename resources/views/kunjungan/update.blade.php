
@extends('master1.layout')

@section('judul','Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/kunjungan">Kunjungan</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Edit Kunjungan</h3>

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

          <form method="POST" action="{{ route('kunjungan.update', $kunjungan->kun_id) }}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-group row">
                    <label for="tanggal_kunjungan" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ $kunjungan->tanggal_kunjungan->format('Y-m-d') }}">
                    </div>
                </div>
              <div class="form-group row">
                  <label for="pengunjung" class="col-sm-2 col-form-label">Pengunjung</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="pengunjung" name="pengunjung" value="{{ $kunjungan->pengunjung }}">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="kota_asal" class="col-sm-2 col-form-label">Kota Asal</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="kota_asal" name="kota_asal" value="{{ $kunjungan->kota_asal }}">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="penerima" class="col-sm-2 col-form-label">Penerima</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="penerima" name="penerima" value="{{ $kunjungan->penerima }}">
                  </div>
              </div>
              <div class="form-group row">
                    <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                    @if ($kunjungan->gambar)
                            <img src="{{ Storage::url($kunjungan->gambar) }}" alt="Gambar Kunjungan" width="100" class="mb-3">
                    @endif
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
              <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-success">Update</button>
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