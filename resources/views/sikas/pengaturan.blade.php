@extends('sikas/layout/layout')

@section('title', 'Pengaturan - Sikas')

@section('vendor-style')
<!-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}"> -->
@endsection

@section('vendor-script')
<!-- <script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script> -->
@endsection

@section('page-script')
<!-- <script src="{{asset('assets/js/datatable-tables.js')}}"></script> -->
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-pengaturan.css')}}">
@endsection

@section('current-pages-title')
  Pengaturan
@endsection

@section('content')
<div class="card card--pengaturan">
  <div class="card-body">
    <form action="#">
      <div class="mb-3">
        <label for="nama_teller" class="form-label">Nama Teller</label>
        <input type="text" class="form-control" id="nama_teller" placeholder="Nama Teller..." value="">
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" placeholder="Username..." value="">
      </div>
      <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
          <label class="form-label" for="password">Password</label>
          <a data-bs-toggle="modal" data-bs-target="#modalEditData" class="text-underline text-primary cursor-pointer">Ganti Password</a>
        </div>
        <div class="input-group input-group-merge">
          <input type="text" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
          <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
        </div>
      </div>
      <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAddSuccess">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--pengaturan fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Pengaturan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="#">
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password_lama">Password Lama</label>
            </div>
            <div class="input-group input-group-merge">
              <input type="text" id="password_lama" class="form-control" name="password_lama" placeholder="············" aria-describedby="password_lama">
              <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
            </div>
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password">Password Baru</label>
            </div>
            <div class="input-group input-group-merge">
              <input type="text" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
              <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
            </div>
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="re_password">Ulangi Password Anda</label>
            </div>
            <div class="input-group input-group-merge">
              <input type="text" id="re_password" class="form-control" name="re_password" placeholder="············" aria-describedby="re_password">
              <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
            </div>
            <p class="color-neutral-80 mt-1"><span class="text-danger">Password tidak sama</span>, pastikan kembali bahwa anda memasukkan password yang sama.</p>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAddSuccess">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--pengaturan fade" id="modalAddSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menyimpan Data</h4>
          <p class="color-neutral-80">Data User Berhasil Disimpan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--pengaturan fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Data User Berhasil Diubah</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
