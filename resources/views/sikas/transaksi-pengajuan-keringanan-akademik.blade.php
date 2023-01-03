@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran Akademik - Sikas')

@section('vendor-style')
<!-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"> -->
@endsection

@section('vendor-script')
<!-- <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script> -->
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/pembayaran.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-pembayaran.css')}}">
@endsection

@section('current-pages-title')
  Transaksi
@endsection

@section('content')
<p class="fw-bold mb-5">
  <span class="text-muted fw-light">Transaksi / Pembayaran / Akademik /</span> Pengajuan Keringanan
</p>
<div class="card pengajuan-keringanan">
  <div class="detail-siswa">
    <div class="detail-siswa__profile">
      <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
        <i class="fa-regular fa-user detail-siswa__icon"></i>
        <div class="d-flex flex-column gap-1">
          <h5 class="text-bold color-neutral-100">Anastasya Anzella</h5>
          <p class="nomor-siswa color-neutral-80">120293487</p>
        </div>
      </div>
      <div class="d-flex flex-row justify-content-between align-items-center gap-3 mt-3 detail-siswa-history__subs">
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Kelas</p>
          <p class="text-bold color-neutral-100">XI TKJ 2</p>
        </div>
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Sisa Tanggungan</p>
          <h5 class="text-bold text-primary">1.300.000</h5>
        </div>
      </div>
    </div>
    <div class="horizontal-line my-5"></div>
    <div class="tahun-ajaran">
      <label for="tahunAjaran" class="form-label">Cari Berdasarkan Tahun Ajaran</label>
      <div class="tahun-ajaran-input">
        <input type="number" class="form-control" id="tahunAjaran" placeholder="2023">
        <i class="fa-regular fa-calendar input-icon color-neutral-50"></i>
      </div>
    </div>
    <div class="table-responsive text-nowrap mt-4">
      <table class="table table-striped" id="riwayat-pengajuan-keringanan">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jumlah Keringanan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p class="color-neutral-100">January, 02 2023</p>
            </td>
            <td>
              <p class="color-neutral-100">+ Rp. 700.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="color-neutral-100">January, 02 2023</p>
            </td>
            <td>
              <p class="color-neutral-100">+ Rp. 700.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="color-neutral-100">January, 02 2023</p>
            </td>
            <td>
              <p class="color-neutral-100">+ Rp. 700.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="color-neutral-100">January, 02 2023</p>
            </td>
            <td>
              <p class="color-neutral-100">+ Rp. 700.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="color-neutral-100">January, 02 2023</p>
            </td>
            <td>
              <p class="color-neutral-100">+ Rp. 700.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="color-neutral-100">January, 02 2023</p>
            </td>
            <td>
              <p class="color-neutral-100">+ Rp. 700.000</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="border-line"></div>
  <div class="pengajuan-keringanan__form">
    <h4 class="text-bold color-black mb-4">Form Pengajuan Keringanan</h4>
    <form action="#" class="pengajuan-keringanan-form">
      <div class="pengajuan-keringanan-form__input-wrapper">
        <div class="pengajuan-keringanan-form__input">
          <label for="upload-surat-pengajuan" class="form-label">Upload Surat Pengajuan </label>
          <input class="form-control" type="file" id="upload-surat-pengajuan" multiple="">
        </div>
        <div class="pengajuan-keringanan-form__item-upload">
          <i class="fa-solid fa-file-pdf text-primary file-icon"></i>
          <p class="color-neutral-100 file-name">Account-receible.pdf</p>
          <a href="#" class="delete-file">
            <i class="fa-solid fa-xmark color-dark-subtle delete-file__icon"></i>
          </a>
        </div>
      </div>
      <div class="mt-3">
        <label for="nominalPembayaran" class="form-label text-bold color-black">Nominal Keringanan</label>
        <input type="number" min="0" class="form-control" id="nominalPembayaran" placeholder="0.00">
      </div>
      <button class="btn btn-primary pengajuan-keringanan-button mt-4" data-bs-toggle="modal" data-bs-target="#modalPengajuanKeringanan">Bayar Sekarang</button>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalPengajuanKeringanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengajukan Keringanan</h4>
          <p class="color-neutral-80">Lanjutkan untuk melakukan proses pembayaran pada halaman pembayaran</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
