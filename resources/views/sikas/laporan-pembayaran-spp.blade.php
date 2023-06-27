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
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3 d-none" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-laporan-per-kelas" aria-controls="navs-laporan-per-kelas" aria-selected="false">Laporan BPP Per Kelas</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-laporan-per-kelas" role="tabpanel">
          <div class="d-flex justify-content-between align-items-end mb-5 gap-3 flex-wrap">
            <div class="filter-siswa d-flex align-items-end gap-3">
              <div class="mt-3">
                <label for="filter_id_kelas_kelas" class="form-label text-bold color-black">Kelas</label>
                <select id="filter_id_kelas_kelas" autocomplete="off" class="form-select">
                  <option value="" disabled selected>Pilih Kelas</option>
                  @foreach($kelas as $k)
                  <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mt-3">
                <label for="filter_id_jurusan_kelas" class="form-label text-bold color-black">Jurusan</label>
                <select id="filter_id_jurusan_kelas" autocomplete="off" class="form-select">
                  <option value="" disabled selected>Pilih Jurusan</option>
                  @foreach($jurusan as $j)
                  <option value="{{ $j->id_jurusan }}">{{ $j->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mt-3">
                <label for="filter_nomor_kelas_kelas" class="form-label text-bold color-black">Nomor Kelas</label>
                <select id="filter_nomor_kelas_kelas" autocomplete="off" class="form-select">
                  <option value="" disabled selected>Pilih Nomor Kelas</option>
                  @for($q = 1; $q <= $nomor_kelas; $q++)
                  <option value="{{ $q }}">{{ $q }}</option>
                  @endfor
                </select>
              </div>
              <div class="mt-3">
                <label for="filter_angkatan_siswa_kelas" class="form-label text-bold color-black">Angkatan</label>
                <select id="filter_angkatan_siswa_kelas" autocomplete="off" class="form-select">
                  <option value="" selected>Aktif</option>
                  @foreach($all_angkatan as $aa)
                  <option value="{{ $aa }}">{{ $aa }}</option>
                  @endforeach
                </select>
              </div>
              <!-- <button type="button" class="btn btn-outline-primary cari-siswa-button">Filter Data</button> -->
            </div>
            <div class="d-flex align-items-center justify-content-end gap-4">
              <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
              <button class="d-flex btn btn-primary gap-2 align-items-center btn-cetak-laporan" id="button-cetak-laporan-kelas">
                Cetak Laporan
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>
            <div class="d-none">
              <div class="date-range">
                <div id="date-range-span" class="form-control">
                  <span></span>
                </div>
                <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
                <input type="hidden" name="date-range-input" value="" class="" id="date-range-input" />
              </div>
            </div>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="data-laporan-pembayaran-spp-perkelas">
              <thead id="thead-laporan-spp-kelas">
              </thead>
              <tbody id="tbody-laporan-spp-kelas">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection