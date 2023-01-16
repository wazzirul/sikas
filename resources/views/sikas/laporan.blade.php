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
      <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
      <a href="{{route('sikas-laporan--penggunaan-dana')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-school jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Penggunaan Dana</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pemasukan-dari-sumber-lain')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-regular fa-building jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pemasukan dari Sumber Lain</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pengajuan-keringanan')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-money-bill-wave jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pengajuan Keringanan</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pembayaran-spp')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-graduation-cap jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pembayaran SPP</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-laporan--pembayaran-tabungan')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-laporan__link">
        <div class="jenis-laporan__icon-wrap">
          <i class="fa-solid fa-credit-card jenis-laporan__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-laporan__icon jenis-laporan__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5 jenis-laporan__name">Laporan Pembayaran Tabungan</h5>
    </div>
  </div>
</div>
<div class="card card--laporan">
  <div class="laporan-wrapper">
    <h4 class="text-bold color-black mb-4">Data Laporan</h4>
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
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
      <table class="table table-striped" id="data-laporan">
        <thead>
          <tr>
            <th rowspan="2" align="center">
              <h6 class="text-bold color-black">Tanggal</h6>
            </th>
            <th rowspan="2" align="center" class="data-laporan__keterangan">
              <h6 class="text-bold color-black">Keterangan</h6>
            </th>
            <th colspan="2">
              <h6 class="text-bold color-black">Dana Penunjang Kegiatan Sekolah (BPP)</h6>
            </th>
            <th colspan="2">
              <h6 class="text-bold color-black">Tabungan UMUM</h6>
            </th>
          </tr>
          <tr>
            <th>
              <p class="text-bold color-black">Debet</p>
            </th>
            <th>
              <p class="text-bold color-black">Kredit</p>
            </th>
            <th>
              <p class="text-bold color-black">Debet</p>
            </th>
            <th>
              <p class="text-bold color-black">Kredit</p>
            </th>
          </tr>
        </thead>
        <tbody id="tbody-laporan">
          <!-- Saldo -->
          <tr>
            <td>
              <p class="text-bold text-primary">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-bold text-primary">Saldo {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi-laporan">{{ $bpp_sekolah }}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi-laporan">{{ $tabungan_sekolah }}</p>
            </td>
            <td>
              <p class="text-bold text-primary nominal-transaksi-laporan">-</p>
            </td>
          </tr>

          <!-- Penerimaan BPP -->
          <tr>
            <td>
              @if($data_spp_bulan_ini != null)
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::parse($data_spp_bulan_ini->tanggal)->translatedFormat('d F Y') }}</p>
              @else
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
              @endif
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penerimaan BPP</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">{{ $spp_bulan_ini }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
          </tr>

          <!-- Penerimaan Tabungan -->
          <tr>
            <td>
              @if($data_tabungan_bulan_ini != null)
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::parse($data_tabungan_bulan_ini->tanggal)->translatedFormat('d F Y') }}</p>
              @else
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
              @endif
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penerimaan Tabungan</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">{{ $tabungan_bulan_ini }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
          </tr>

          <!-- Penarikan Tabungan -->
          <tr>
            <td>
              @if($data_tarik_tabungan_bulan_ini != null)
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::parse($data_tarik_tabungan_bulan_ini->tanggal)->translatedFormat('d F Y') }}</p>
              @else
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
              @endif
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">Penarikan Tabungan</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">{{ $tarik_tabungan_bulan_ini }}</p>
            </td>
          </tr>

          @foreach($transaksi_lain_bulan_ini as $tlbi)
          <tr>
            <td>
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::parse($tlbi->tanggal)->translatedFormat('d F Y') }}</p>
            </td>
            <td class="data-laporan__keterangan">
              <p class="text-medium color-neutral-100">{{ $tlbi->nama_transaksi }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">{{ $tlbi->tipe_transaksi == 5 ? $tlbi->jumlah : '-' }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">{{ $tlbi->tipe_transaksi == 4 ? $tlbi->jumlah : '-' }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi-laporan">-</p>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection