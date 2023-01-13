@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran Akademik - Sikas')

@section('vendor-style')
<!-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"> -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('vendor-script')
<!-- <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script> -->
<script src="{{asset('assets/vendor/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/terbilangjs/terbilang.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/print-receipt.js')}}"></script>
<script src="{{asset('assets/js/pages/pembayaran-akademik.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi / </span> Pembayaran Akademik
</p>
<div class="card card--pembayaran">
  <div class="card-body">    
    <h3 class="text-bold mb-4">Form Pembayaran Uang Akademik</h3>
    <div class="card-body__wrapper">
      <div class="card-item card-item--cari-siswa">
        <label class="text-bold mb-3" for="cari-siswa">Cari Siswa</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text" id="cari-siswa-icon"><i class="bx bx-search"></i></span>
          <input type="text" id="cari-siswa" class="form-control" placeholder="Masukkan nama atau NIS" aria-label="Masukkan nama atau NIS" aria-describedby="cari-siswa-icon">
          <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
        </div>
        <div class="cari-siswa">
          @foreach($anggota as $a)
          <div class="cari-siswa__item" data-id="{{ $a->id_anggota }}">
            <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
              <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
              <div class="d-flex flex-column gap-1">
                <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">{{ $a->nama }}</p>
                <p class="nomor-siswa color-neutral-80">{{ $a->nis }}</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-1">
              <p class="text-bold color-neutral-100">Kelas</p>
              <p class="kelas-siswa color-neutral-80">{{ $a->Kelas->nama }} {{ $a->Jurusan->nama }} {{ $a->nomor_kelas }}</p>
            </div>
            <a href="#" class="cari-siswa__item-detail">
              <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
            </a>
          </div>
          @endforeach
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration-2.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Belum Ada Pencarian</h4>
            <p class="color-neutral-80">Masukkan nama lengkap siswa / nis untuk melakukan pencarian.</p>
          </div>
        </div>
      </div>
      <div class="horizontal-line"></div>
      <div class="card-item">
        <form id="form-pembayaran-akademik" action="/query/postPembayaranAkademik" method="POST" class="card-item--detail-dan-form">
          {{ csrf_field() }}
          <div class="detail-siswa">
            <div class="d-flex flex-row justify-content-between align-items-center gap-2">
              <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
                <i class="fa-regular fa-user detail-siswa__icon"></i>
                <div class="d-flex flex-column gap-1">
                  <h5 class="text-bold color-neutral-100 detail-nama">Nama Siswa</h5>
                  <p class="nomor-siswa color-neutral-80 detail-nis">-</p>
                </div>
              </div>
            </div>
            <div class="d-flex flex-row justify-content-between align-items-center gap-2 mt-3">
              <div class="d-flex flex-column gap-1">
                <p class="color-neutral-80">Kelas</p>
                <p class="text-bold color-neutral-100 detail-kelas">-</p>
              </div>              
              <div class="d-flex flex-column gap-1">
                <p class="color-neutral-80">Sisa Tanggungan</p>
                <h5 class="text-bold text-primary detail-tagihan">0</h5>
              </div>
            </div>
          </div>
          <div class="">
            <label for="nominalPembayaran" class="form-label">Nominal Pembayaran</label>
            <input type="text" class="form-control" id="nominalPembayaran" name="nominalPembayaran" placeholder="0.00">
            <input type="hidden" id="id_anggota" name="id_anggota" />
          </div>
          <button class="btn btn-primary pembayaran-button disabled" data-bs-toggle="modal" data-bs-target="#modalPembayaran">Bayar Sekarang</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card card--riwayat-transaksi mt-5">
  <h4 class="color-neutral-100 mb-5">Riwayat Transaksi Pembayaran Akademik</h4>
  <a href="#!" class="btn btn-outline-primary ajukan-keringanan">Ajukan Keringanan</a>
  <div class="card-body">
    <div class="table-responsive text-nowrap mt-4">
      <table class="table table-striped" id="history-pembayaran">
        <caption class="ms-4">Daftar History Pembayaran</caption>
        <thead>
          <tr>
            <th class="text-bold">Jenis Pembayaran</th>
            <th class="text-bold">Tanggal</th>
            <th class="text-bold">Jumlah Pembayaran</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="color-neutral-100">Uang SPP</td>
            <td class="color-neutral-100">January, 13 2023</td>
            <td class="color-neutral-100 nominal-transaksi">+ Rp. 50.000</td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="javascript:void(0)" title="Cetak ulang struk" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-print"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
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