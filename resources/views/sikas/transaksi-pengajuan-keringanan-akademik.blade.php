@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran Akademik - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<!-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"> -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<!-- <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script> -->
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/terbilangjs/terbilang.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/print-receipt.js')}}"></script>
<script src="{{asset('assets/js/pages/pengajuan-keringanan.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi / Pembayaran Akademik /</span> Pengajuan Keringanan
</p>
<div class="card pengajuan-keringanan">
  <div class="detail-siswa">
    <div class="detail-siswa__profile">
      <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
        <i class="fa-regular fa-user detail-siswa__icon"></i>
        <div class="d-flex flex-column gap-1">
          <h5 class="text-bold color-neutral-100">{{ $anggota->nama }}</h5>
          <p class="nomor-siswa color-neutral-80">{{ $anggota->nis }}</p>
        </div>
      </div>
      <div class="d-flex flex-row justify-content-between align-items-center gap-3 mt-3 detail-siswa-history__subs">
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Kelas</p>
          <p class="text-bold color-neutral-100">{{ $anggota->Kelas->nama }} {{ $anggota->Jurusan->nama }} {{ $anggota->nomor_kelas }}</p>
        </div>
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Sisa Tanggungan</p>
          <h5 class="text-bold text-primary sisa-tanggungan">{{ $anggota->KeuanganAnggota->tagihan }}</h5>
        </div>
      </div>
    </div>
    <div class="horizontal-line my-5"></div>
    <div class="tahun-ajaran">
      <label for="tahunAjaran" class="form-label">Cari Berdasarkan Tahun Ajaran</label>
      <div class="tahun-ajaran-input">
        <input type="number" class="form-control" id="tahunAjaran" placeholder="2023">
        <i class="fa-regular fa-calendar input-icon color-neutral-50"></i>
      </div>
    </div>
    <div class="table-responsive text-nowrap mt-4">
      <table class="table table-striped" id="riwayat-pengajuan-keringanan">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jumlah Keringanan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($history as $h)
          <tr>
            <td>
              <p class="color-neutral-100">{{ \Carbon\Carbon::parse($h->tanggal)->translatedFormat('F, d Y') }}</p>
            </td>
            <td>
              <p class="color-neutral-100 nominal-transaksi">{{ $h->jumlah }}</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-start gap-3">
                <a href="#!" class="table__link-detail d-flex align-items-center gap-2 detail-pengajuan" data-file="{{ $h->file }}" data-jumlah="{{ $h->jumlah }}" data-bs-toggle="modal" data-bs-target="#modalPengajuanKeringananDetail">
                  Lihat Detail
                  <i class="fa-solid fa-eye"></i>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="border-line"></div>
  <div class="pengajuan-keringanan__form">
    <h4 class="text-bold color-black mb-4">Form Pengajuan Keringanan</h4>
    <form id="form-pengajuan-keringanan" action="/query/postPengajuanKeringanan" class="pengajuan-keringanan-form" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name="id_anggota" value="{{ $anggota->id_anggota }}" />
      <div class="pengajuan-keringanan-form__input-wrapper">
        <div class="pengajuan-keringanan-form__input">
          <label for="upload-surat-pengajuan" class="form-label">Upload Surat Pengajuan </label>
          <input class="form-control" type="file" name="file-pengajuan" id="upload-surat-pengajuan" autocomplete="off" accept="application/pdf">
        </div>
        <div class="pengajuan-keringanan-form__item-upload d-none">
          <i class="fa-solid fa-file-pdf text-primary file-icon"></i>
          <p class="color-neutral-100 file-name">-</p>
        </div>
      </div>
      <div class="mt-3">
        <label for="nominalPembayaran" class="form-label text-bold color-black">Nominal Keringanan</label>
        <input type="text" min="0" class="form-control" id="nominalPembayaran" name="nominalPembayaran" placeholder="0.00">
      </div>
      <button class="btn btn-primary pengajuan-keringanan-button mt-4" data-bs-toggle="modal" data-bs-target="#modalPengajuanKeringanan">Ajukan Keringanan</button>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalPengajuanKeringanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengajukan Keringanan</h4>
          <p class="color-neutral-80">Lanjutkan untuk melakukan proses pembayaran pada halaman pembayaran</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--pengajuan-keringanan fade" id="modalPengajuanKeringananDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Detail Pengajuan Keringanan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <div class="pengajuan-keringanan-detail mt-5">
          <div class="d-flex flex-column mb-5 align-items-center text-center">
            <h4 class="color-black mb-3">Jumlah Keringanan</h4>
            <h5 class="text-bold text-success modal-jumlah">-</h5>
          </div>
          <h6 class="text-bold mb-3">Surat Pengajuan</h6>
          <a href="#" download class="d-flex flex-row align-items-center pengajuan-keringanan-form__item-upload gap-3 modal-download">
            <i class="fa-solid fa-file-pdf text-primary file-icon"></i>
            <p class="color-neutral-100 modal-file">Account-receible.pdf</p>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection