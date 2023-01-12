@extends('sikas/layout/layout')

@section('title', 'Reset Tahun Ajar - Sikas')

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
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-reset-tahun-ajar.css')}}">
@endsection

@section('current-pages-title')
  Reset Tahun Ajar
@endsection

@section('content')
<div class="card card--reset-tahun-ajar">
  <div class="card-body">
    <form action="#">
      <div class="text-center reset-tahun-ajar__content">
        <h4 class="text-bold text-danger reset-tahun-ajar__title">RESET TAHUN AJAR</h4>
        <p class="color-black reset-tahun-ajar__subtitle">Memulai tahun ajaran baru, <span class="text-primary text-bold">semua siswa dan siswi akan secara otomatis naik kelas</span>. Jika ada siswa / siswi yang tidak naik kelas, harap di ubah secara manual di menu siswa.</p>
      </div>
      <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalEditData">Mulai Tahun Ajar Baru</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--reset-tahun-ajar fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Mulai Tahun Ajar Baru</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="#">
          <div class="mb-3">
            <label for="jenis_pembayaran" class="form-label">Nama / Jenis Pembayaran</label>
            <input type="text" class="form-control" id="jenis_pembayaran" placeholder="Nama / Jenis Pembayaran..." value="">
          </div>
          <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="text" class="form-control" id="nominal" placeholder="Nominal..." value="">
          </div>
          <div class="form-text"> <span class="text-primary text-bold">semua siswa dan siswi akan secara otomatis naik kelas</span>. Jika ada siswa / siswi yang tidak naik kelas, harap di ubah secara manual di menu siswa. </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Mulai Tahun Ajar Baru</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--reset-tahun-ajar fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Berhasil Memulai Tahun Ajar Baru</h4>
          <p class="color-neutral-80">Tahun Ajar Baru Berhasil dimulai, <span class="text-primary text-bold">semua siswa dan siswi akan secara otomatis naik kelas</span>. Jika ada siswa / siswi yang tidak naik kelas, harap di ubah secara manual di menu siswa. </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
