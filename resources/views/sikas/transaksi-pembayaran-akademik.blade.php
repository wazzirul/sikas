@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran Akademik - Sikas')

@section('vendor-style')
<!-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"> -->
@endsection

@section('vendor-script')
<!-- <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script> -->
@endsection

@section('page-script')
<!-- <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script> -->
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
  <span class="text-muted fw-light">Transaksi / Pembayaran /</span> Akademik
</p>
<div class="card card--pembayaran">
  <div class="card-body">
    <div class="card-item card-item--cari-siswa">
      <label class="text-bold mb-3" for="cari-siswa">Cari Siswa</label>
      <div class="input-group input-group-merge">
        <span class="input-group-text" id="cari-siswa-icon"><i class="bx bx-search"></i></span>
        <input type="text" id="cari-siswa" class="form-control" placeholder="Masukkan nama atau NISN" aria-label="Masukkan nama atau NISN" aria-describedby="cari-siswa-icon">
      </div>
      <div class="cari-siswa">
        <div class="cari-siswa__item">
          <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
            <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
            <div class="d-flex flex-column gap-1">
              <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">Tasya Savella</p>
              <p class="nomor-siswa color-neutral-80">172410103029</p>
            </div>
          </div>
          <div class="d-flex flex-column gap-1">
            <p class="text-bold color-neutral-100">Kelas</p>
            <p class="kelas-siswa color-neutral-80">XI TKJ 2</p>
          </div>
          <a href="#" class="cari-siswa__item-detail">
            <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
          </a>
        </div>
        <div class="cari-siswa__item">
          <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
            <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
            <div class="d-flex flex-column gap-1">
              <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">Anastasya Anzella</p>
              <p class="nomor-siswa color-neutral-80">120293487</p>
            </div>
          </div>
          <div class="d-flex flex-column gap-1">
            <p class="text-bold color-neutral-100">Kelas</p>
            <p class="kelas-siswa color-neutral-80">XI TKJ 3</p>
          </div>
          <a href="#" class="cari-siswa__item-detail">
            <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="horizontal-line"></div>
    <div class="card-item">
      <form action="#" class="card-item--detail-dan-form">
        <h3 class="text-bold">Detail Siswa</h3>
        <div class="detail-siswa">
          <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
            <i class="fa-regular fa-user detail-siswa__icon"></i>
            <div class="d-flex flex-column gap-1">
              <h5 class="text-bold color-neutral-100">Anastasya Anzella</h5>
              <p class="nomor-siswa color-neutral-80">120293487</p>
            </div>
          </div>
          <div class="d-flex flex-row justify-content-between align-items-center gap-2 mt-3">
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
        <div class="d-flex flex-row justify-content-between align-items-center gap-3">
          <a href="{{route('sikas-transaksi--pembayaran-pengajuan-keringanan')}}" class="btn btn-outline-primary">Ajukan Keringanan</a> 
          <a href="{{route('sikas-transaksi--pembayaran-history')}}" class="detail-siswa__history-pembayaran text-primary">Lihat History Pembayaran</a>
        </div>
        <div class="">
          <label for="nominalPembayaran" class="form-label">Nominal</label>
          <input type="text" class="form-control" id="nominalPembayaran" placeholder="Rp. 0.00">
        </div>
        <button class="btn btn-primary pembayaran-button" data-bs-toggle="modal" data-bs-target="#modalPembayaran">Bayar Sekarang</button>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalPembayaran" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Melakukan Pembayaran</h4>
          <p class="color-neutral-80">Anda bisa melihat detail pembayaran yang baru saja anda lakukan di halaman home.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
