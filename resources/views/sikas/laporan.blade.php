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
      <a href="{{route('sikas-laporan--bpp')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-graduation-cap jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan BPP</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pembayaran-tabungan')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-coins jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pembayaran Tabungan</h5>
    </div>
  </div>
</div>
@endsection