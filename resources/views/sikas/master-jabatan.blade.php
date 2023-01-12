@extends('sikas/layout/layout')

@section('title', 'Jenis Pembayaran - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/jabatan.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-master-jabatan.css')}}">
@endsection

@section('current-pages-title')
  Master Jabatan
@endsection

@section('content')
<div class="card card--master-jabatan">
  <div class="jenis-pembayaran-wrapper">
    <h4 class="text-bold color-black mb-4">Data Master Jabatan</h4>    
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
      <div class="d-flex align-items-center gap-4">
        <button class="d-flex btn btn-primary gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#modalAddData">
          Tambah Master Jabatan
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-master-jabatan">
        <thead>
          <tr>
            <th>ID</th>
            <th>Master Jabatan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($jabatan as $j)
          <tr>
            <td>
              <p class="text-medium color-neutral-100">{{ $j->id_struktur_sekolah }}</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $j->jabatan }}</p>              
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-primary" onClick="changeStrukturSekolah({{$j->id_struktur_sek}})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-primary" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  Hapus <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--master-jabatan fade" id="modalAddData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Tambah Master Jabatan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="/master-jabatan/post" method="POST">
          {{ csrf_field() }}
          <div class="mb-3">
            <label for="master_jabatan" class="form-label">Nama / Master Jabatan</label>
            <input type="text" class="form-control" name="jabatan" id="master_jabatan" placeholder="Nama / Master Jabatan..." >
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAddSuccess">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--master-jabatan fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Master Jabatan</h4>
          <input type="hidden" id="id_struktur_sekolah"/>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
          <div class="mb-3">
            <label for="update_jabatan" class="form-label">Nama / Master Jabatan</label>
            <input type="text" class="form-control" id="update_jabatan" placeholder="Nama / Master Jabatan..." value="">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary w-100 update-jabatan-button" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Simpan</button>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--master-jabatan fade" id="modalDeleteData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Data Master Jabatan</h4>
        </div>
        <div class="mt-3">
          <p class="color-neutral-100 text-center">Apakah anda yakin ingin menghapus data Master Jabatan ‘ <span class="text-bold nama-delete-modal">Satpam</span> ‘</p>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-danger w-100 delete-jabatan-button" data-bs-toggle="modal" data-bs-target="#modalDeleteSuccess">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--master-jabatan fade" id="modalAddSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Data Master Jabatan</h4>
          <p class="color-neutral-80">Data Master Jabatan Berhasil Ditambahkan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--master-jabatan fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Data Master Jabatan Berhasil Diubah</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--master-jabatan fade" id="modalDeleteSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Data</h4>
          <p class="color-neutral-80">Data Master Jabatan Berhasil Dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
