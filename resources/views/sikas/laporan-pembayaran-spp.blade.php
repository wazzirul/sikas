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
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-laporan-per-kelas" aria-controls="navs-laporan-per-kelas" aria-selected="false">Laporan BPP Per Kelas</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-histori-laporan" aria-controls="navs-histori-laporan" aria-selected="true">Riwayat Laporan BPP</button>
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
                <label for="filter_angkatan_siswa" class="form-label text-bold color-black">Angkatan</label>
                <select id="filter_angkatan_siswa" autocomplete="off" class="form-select">
                  <option value="Aktif" selected>Aktif</option>
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
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="data-laporan-pembayaran-spp-perkelas">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Induk</th>
                  <th>Nama Siswa</th>
                  <th class="tcolumn-kelas">Kelas</th>
                  <th>L/P</th>
                  <th>Kesanggupan Partisipasi</th>
                  <th>Angsuran Ke</th>
                  <th>Juli</th>
                  <th>Agust</th>
                  <th>Sept</th>
                  <th>Okt</th>
                  <th>Nov</th>
                  <th>Des</th>
                  <th>Jan</th>
                  <th>Feb</th>
                  <th>Maret</th>
                  <th>April</th>
                  <th>Mei</th>
                  <th>Juni</th>
                  <th>Total Partisipasi</th>
                  <th>Sisa Partisipasi</th>
                </tr>
              </thead>
              <tbody id="tbody-laporan-spp-kelas">
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-histori-laporan" role="tabpanel">
          <div class="d-flex justify-content-between align-items-end mb-5 gap-3 flex-wrap">
            <div class="filter-siswa d-flex align-items-end gap-3">
              <div class="mt-3">
                <label for="filter_id_kelas" class="form-label text-bold color-black">Kelas</label>
                <select id="filter_id_kelas" autocomplete="off" class="form-select">
                  <option value="" selected>Semua</option>
                  @foreach($kelas as $k)
                  <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option018>
                  @endforeach
                  <option value="0">Alumni</option>
                </select>
              </div>
              <div class="mt-3">
                <label for="filter_id_jurusan" class="form-label text-bold color-black">Jurusan</label>
                <select id="filter_id_jurusan" autocomplete="off" class="form-select">
                  <option value="" selected>Semua</option>
                  @foreach($jurusan as $j)
                  <option value="{{ $j->id_jurusan }}">{{ $j->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mt-3">
                <label for="filter_nomor_kelas" class="form-label text-bold color-black">Nomor Kelas</label>
                <select id="filter_nomor_kelas" autocomplete="off" class="form-select">
                  <option value="" selected>Semua</option>
                  @for($q = 1; $q <= $nomor_kelas; $q++)
                  <option value="{{ $q }}">{{ $q }}</option>
                  @endfor
                </select>
              </div>
              <div class="mt-3">
                <label for="filter_angkatan_siswa" class="form-label text-bold color-black">Angkatan</label>
                <select id="filter_angkatan_siswa" autocomplete="off" class="form-select">
                  <option value="" selected>Semua</option>
                  <option value="Aktif">Aktif</option>
                  <option value="2022-2023">2022-2023</option>
                  <option value="2021-2022">2021-2022</option>
                  <option value="2020-2021">2020-2021</option>
                  <option value="2019-2020">2019-2020</option>
                  <option value="2018-2019">2018-2019</option>
                  <option value="2017-2018">2017-2018</option>
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
              <button class="d-flex btn btn-primary gap-2 align-items-center btn-cetak-laporan" id="button-cetak-laporan">
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
                  <th>Nama Teller</th>
                  <th>Nama Siswa</th>
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
                    <p class="text-medium color-neutral-100">{{ $l->Admin->nama }}</p>
                  </td>
                  <td class="text-medium">
                    <p class="text-medium color-neutral-100">{{ $l->Anggota->nama }} </p>
                  </td>
                  <td>
                    <p class="text-medium color-neutral-100 kelas">{{ $l->Anggota->Kelas->nama }} {{ $l->Anggota->Jurusan->nama }} {{ $l->Anggota->nomor_kelas }}</p>
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
    </div>
  </div>
</div>
@endsection