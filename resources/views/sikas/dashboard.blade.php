@extends('sikas/layout/layout')

@section('title', 'Dashboard - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-dashboard.css')}}">
@endsection

@section('current-pages-title')
  Dashboard
@endsection

@section('content')
<div class="row">
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-regular fa-user text-primary avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Jumlah Siswa</span>
        <h3 class="card-title color-black mb-2">2167</h3>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-user-tie text-info avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Jumlah Karyawan</span>
        <h3 class="card-title color-black mb-2">125</h3>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-money-bill-transfer text-success avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Jumlah Transaksi SPP</span>
        <h3 class="card-title color-black mb-2">3549</h3>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-coins text-danger avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Jumlah Transaksi Lain</span>
        <h3 class="card-title color-black mb-2">1472</h3>
      </div>
    </div>
  </div>
</div>
<div class="row mt-5">
  <div class="col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-regular fa-user text-primary avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Jumlah Keringanan yang Diajukan</span>
        <h3 class="card-title color-black mb-2">Rp. 22.500.000,00</h3>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-user-tie text-info avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Jumlah Tabungan Siswa</span>
        <h3 class="card-title color-black mb-2">Rp. 32.150.000,00</h3>
      </div>
    </div>
  </div>
</div>
@endsection
