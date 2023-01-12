@extends('sikas/layout/layout')

@section('title', 'Laporan - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/datatable-tables.js')}}"></script>
<script src="{{asset('assets/js/pages/laporan.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-laporan.css')}}">
@endsection

@section('current-pages-title')
Laporan
@endsection

@section('content')

<div class="jenis-laporan mb-5">
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--penggunaan-dana')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-school jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Penggunaan Dana</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pemasukan-dari-sumber-lain')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-regular fa-building jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pemasukan dari Sumber Lain</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pengajuan-keringanan')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-money-bill-wave jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pengajuan Keringanan</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pembayaran-spp')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-graduation-cap jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pembayaran SPP</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pembayaran-tabungan')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-credit-card jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pembayaran Tabungan</h5>
    </div>
  </div>
</div>
<div class="card card--laporan">
  <div class="laporan-wrapper">
    <h4 class="text-bold color-black mb-4">Data Laporan</h4>
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
      <div class="date-range">
        <div id="date-range-span" class="form-control">
          <span></span>
        </div>
        <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
        <input type="hidden" name="date-range-input" value="" class="" id="date-range-input" />
      </div>
      <button class="d-flex btn btn-primary gap-2 align-items-center" id="button-cetak-laporan">
        Cetak Laporan
        <i class="fa-solid fa-plus"></i>
      </button>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-laporan">
        <thead>
          <tr>
            <th rowspan="2" align="center">
              <h6 class="text-bold color-black">Tanggal</h6>
            </th>
            <th rowspan="2" align="center" class="data-laporan__keterangan">
              <h6 class="text-bold color-black">Keterangan</h6>
            </th>
            <th colspan="2">
              <h6 class="text-bold color-black">Dana Penunjang Kegiatan Sekolah (BPP)</h6>
            </th>
            <th colspan="2">
              <h6 class="text-bold color-black">Tabungan UMUM</h6>
            </th>
          </tr>
          <tr>
            <th>
              <p class="text-bold color-black">Debet</p>
            </th>
            <th>
              <p class="text-bold color-black">Kredit</p>
            </th>
            <th>
              <p class="text-bold color-black">Debet</p>
            </th>
            <th>
              <p class="text-bold color-black">Kredit</p>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p class="text-bold text-primary">02 Januari 2023</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-bold text-primary">Saldo Januari 2023</p>
            </td>
            <td>
              <p class="text-bold text-primary">Rp. 80.252.805</p>
            </td>
            <td>
              <p class="text-bold text-primary">-</p>
            </td>
            <td>
              <p class="text-bold text-primary">Rp. 37.837.510</p>
            </td>
            <td>
              <p class="text-bold text-primary">-</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Pembayaran angsuran Luxio Januari 2023</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 3.647.000</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penarikan tabungan (masjid)</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 250.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penerimaan BPP dan Tabungan</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 12.405.000</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Diterima dari bendahara BOS untuk pembayaran gaji GTT PTT Januari 2023</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 33.657.000</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">-</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection