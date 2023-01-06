@extends('sikas/layout/layout')

@section('title', 'Laporan - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.js')}}"></script>
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
<div class="card card--laporan">
  <div class="laporan-wrapper">
    <h4 class="text-bold color-black mb-4">Data Laporan</h4>    
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
      <div class="date-range">
        <div id="date-range-span" class="form-control">
          <span></span>
        </div>
        <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
        <input type="hidden" name="date-range-input" value="" class="" id="date-range-input"/>
      </div>
      <button class="d-flex btn btn-primary gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#modalAddData">
        Cetak Laporan
        <i class="fa-solid fa-plus"></i>
      </button>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-laporan">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jenis Transaksi</th>
            <th>Keterangan</th>
            <th>Jumlah Nominal</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Pembayaran SPP</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Alfian yoga ‘kelas XI TKJ 2’</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Pemasukan</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Dana Bos</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Pengeluaran</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Operasional sekolah</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">02 Januari 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Pemasukan</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Donatur Wali Murid</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
