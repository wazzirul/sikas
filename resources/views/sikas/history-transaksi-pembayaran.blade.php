@extends('sikas/layout/layout')

@section('title', 'History Pembayaran - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi / Pembayaran /</span> History Pembayaran
</p>
<div class="card card--history-pembayaran">
  <div class="card-body">
    <div class="detail-siswa-history">
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
    <div class="border-line"></div>
    <div class="history-pembayaran-filter d-flex flex-row justify-content-between align-items-end">
      <div class="tahun-ajaran">
        <label for="tahunAjaran" class="form-label">Cari Berdasarkan Tahun Ajaran</label>
        <div class="tahun-ajaran-input">
          <input type="number" class="form-control" id="tahunAjaran" placeholder="2023">
          <i class="fa-regular fa-calendar input-icon color-neutral-50"></i>
        </div>
      </div>
      <a href="#" class="btn btn-outline-primary">
        Export
        <i class="fa-solid fa-print text-primary"></i>
      </a>
    </div>
    <div class="table-responsive text-nowrap mt-4">
      <table class="table table-striped" id="history-pembayaran">
        <caption class="ms-4">Daftar History Pembayaran</caption>
        <thead>
          <tr>
            <th class="text-bold">Jenis Pembayaran</th>
            <th class="text-bold">Tanggal</th>
            <th class="text-bold">Jumlah Pembayaran</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="color-neutral-100">Uang SPP</td>
            <td class="color-neutral-100">January, 02 2023</td>
            <td class="color-neutral-100">+ Rp. 700.000</td>
          </tr>
          <tr>
            <td class="color-neutral-100">Uang SPP</td>
            <td class="color-neutral-100">January, 02 2023</td>
            <td class="color-neutral-100">+ Rp. 700.000</td>
          </tr>
          <tr>
            <td class="color-neutral-100">Uang SPP</td>
            <td class="color-neutral-100">January, 02 2023</td>
            <td class="color-neutral-100">+ Rp. 700.000</td>
          </tr>
          <tr>
            <td class="color-neutral-100">Uang SPP</td>
            <td class="color-neutral-100">January, 02 2023</td>
            <td class="color-neutral-100">+ Rp. 700.000</td>
          </tr>
          <tr>
            <td class="color-neutral-100">Uang SPP</td>
            <td class="color-neutral-100">January, 02 2023</td>
            <td class="color-neutral-100">+ Rp. 700.000</td>
          </tr>
          <tr>
            <td class="color-neutral-100">Uang SPP</td>
            <td class="color-neutral-100">January, 02 2023</td>
            <td class="color-neutral-100">+ Rp. 700.000</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
