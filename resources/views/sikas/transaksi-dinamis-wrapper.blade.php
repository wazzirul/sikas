@extends('sikas/layout/layout')

@section('title', 'Transaksi Pengeluaran - Sikas')

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
<script src="{{asset('assets/js/unduh-format-data.js')}}"></script>
<script src="{{asset('assets/js/pages/pengeluaran.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-transaksi-dinamis.css')}}">
@endsection

@section('current-pages-title')
  Transaksi
@endsection

@section('content')

<div class="card-body__header d-flex flex-row justify-content-between align-items-start gap-1 mb-5">
  <p class="fw-bold mb-5">
    <span class="text-muted fw-light">Transaksi /</span> Dinamis
  </p>
</div>

<div class="transaksi-dinamis__wrapper">
  <a class="transaksi-dinamis__link" href="#" target="_blank">Wisuda</a>
  <a class="transaksi-dinamis__link" href="#" target="_blank">Seragam</a>
  <a class="transaksi-dinamis__link" href="#" target="_blank">Rekreasi</a>
  <a class="transaksi-dinamis__link" href="#" target="_blank">Buku</a>
</div>

@endsection
