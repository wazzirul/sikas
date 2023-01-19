@extends('sikas/layout/layout')

@section('title', 'Laporan Biaya Penunjang Pendidikan - Sikas')

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
    <h4 class="text-bold color-black mb-4">Data Laporan Biaya Penunjang Pendidikan</h4>
    <div class="d-flex justify-content-between align-items-end mb-5 gap-3">
      <div class="filter-siswa d-flex align-items-end gap-3">
        <div class="mt-3">
          <label for="filter_id_kelas" class="form-label text-bold color-black">Kelas</label>
          <select id="filter_id_kelas" autocomplete="off" class="form-select">
            <option value="all">Semua</option>
            <option value="1">X</option>
            <option value="2">XI</option>
            <option value="3">XII</option>
          </select>
        </div>
        <div class="mt-3">
          <label for="filter_id_jurusan" class="form-label text-bold color-black">Jurusan</label>
          <select id="filter_id_jurusan" autocomplete="off" class="form-select">
            <option value="all">Semua</option>
            <option value="1">TKJ</option>
            <option value="2">RPL</option>
            <option value="3">Multimedia</option>
          </select>
        </div>
        <div class="mt-3">
          <label for="filter_nomor_kelas" class="form-label text-bold color-black">Nomor Kelas</label>
          <select id="filter_nomor_kelas" autocomplete="off" class="form-select">
            <option value="all">Semua</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <!-- <button type="button" class="btn btn-outline-primary cari-siswa-button">Filter Data</button> -->
      </div>
      <div class="d-flex align-items-center justify-content-end gap-4">
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
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-laporan-pembayaran-spp">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Keterangan</th>
            <th>Jumlah Nominal</th>
          </tr>
        </thead>
        <tbody id="tbody-laporan-spp">
          @foreach($laporan as $l)
          <tr>
            <td>
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::parse($l->tanggal)->translatedFormat('d F Y') }}</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $l->Anggota->nama }} </p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $l->Anggota->Kelas->nama }} {{ $l->Anggota->Jurusan->nama }} {{ $l->Anggota->nomor_kelas }}</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $l->nama_transaksi }}</p>
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