@extends('sikas/layout/layout')

@section('title', 'Laporan Pembayaran SPP - Sikas')

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
<script src="{{asset('assets/js/pages/laporan-spp.js')}}"></script>
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
    <h4 class="text-bold color-black mb-4">Data Laporan Pembayaran SPP</h4>
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
      <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
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
      <table class="table table-striped" id="data-laporan-pembayaran-spp">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jenis Transaksi</th>
            <th>Keterangan</th>
            <th>Jumlah Nominal</th>
          </tr>
        </thead>
        <tbody id="tbody-laporan-spp">
          @foreach($laporan as $l)
          <tr>
            <td>
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::parse($l->tanggal)->formatLocalized('%d %B %Y') }}</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $l->nama_transaksi }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $l->Anggota->nama }} ‘kelas {{ $l->Anggota->Kelas->nama }} {{ $l->Anggota->Jurusan->nama }} {{ $l->Anggota->nomor_kelas }}’</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">{{ $l->jumlah }}</p>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection