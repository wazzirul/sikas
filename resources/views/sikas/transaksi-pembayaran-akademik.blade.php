@extends('sikas/layout/layout')

@section('title', 'Transaksi Biaya Penunjang Pendidikan - Sikas')

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
<div class="card-body__header d-flex flex-row justify-content-between align-items-start gap-1 mb-5">
  <p class="fw-bold">
    <span class="text-muted fw-light">Transaksi / </span> Biaya Penunjang Pendidikan
  </p>
  <form action="/siswa/import" id="importForm" class="form-upload-siswa" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
    <input type="file" name="file" id="siswa-upload-file" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
    <label for="siswa-upload-file" class="btn bg-lg btn-outline-primary btn-import-transaksi d-flex gap-2 align-items-center w-max-content ml-auto">
        Import Transaksi BPP
        <i class="fa-solid fa-arrow-up-from-bracket"></i>
    </label>
  </form>
</div>
<div class="card card--pembayaran">
  <div class="card-body">
    <h3 class="text-bold mb-4">Form Biaya Penunjang Pendidikan</h3>
    <div class="card-body__wrapper">
      <div class="card-item card-item--cari-siswa">
        <div class="filter-siswa d-flex align-items-end gap-3 mb-3">
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
        <label class="text-bold mb-3" for="cari-siswa">Cari Siswa</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text" id="cari-siswa-icon"><i class="bx bx-search"></i></span>
          <input type="text" id="cari-siswa" class="form-control" autocomplete="off" placeholder="Masukkan nama atau NIS" aria-label="Masukkan nama atau NIS" aria-describedby="cari-siswa-icon">
          <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
        </div>
        <div class="cari-siswa">
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
                <p class="color-neutral-80">Sisa Partisipasi BPP</p>
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

<div class="card card--riwayat-transaksi mt-5 d-none">
  <h4 class="color-neutral-100 mb-5">Riwayat Transaksi Biaya Penunjang Pendidikan</h4>
  <div class="d-flex align-items-center justify-content-end gap-3">
    <a href="#!" class="btn btn-primary w-max-content ajukan-penambahan ajukan-penambahan-button">Ajukan Penambahan</a>
    <a href="#!" class="btn btn-outline-primary w-max-content ajukan-keringanan ajukan-keringanan-button">Ajukan Keringanan</a>
  </div>
  <div class="card-body">
    <div class="table-responsive text-nowrap mt-4">
      <table class="table table-striped" id="history-pembayaran" data-username="{{ \Session::get('nama') }}">
        <thead>
          <tr>
            <th class="text-bold">Jenis Pembayaran</th>
            <th class="text-bold">Tanggal</th>
            <th class="text-bold">Nama Teller</th>
            <th class="text-bold">Jumlah Pembayaran</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="list-riwayat-pembayaran-spp">
        </tbody>
      </table>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state history-empty d-none">
      <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
      <h4 class="text-bold color-neutral-100">Data Pembayaran SPP Kosong</h4>
      <p class="color-neutral-80">Silahkan tambahkan data pembayaran terlebih dulu untuk melihat data pembayaran spp.</p>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Edit Transaksi Pembayaran</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <div class="mt-5">
          <label for="jumlah-pembayaran" class="form-label">Jumlah Pembayaran</label>
          <input type="hidden" id="id_transaksi" />
          <input type="text" class="form-control" id="jumlah-pembayaran" placeholder="Rp. 0.00">
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-primary w-100 update-transaksi-button" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalDeleteData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Transaksi Pembayaran</h4>
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-danger w-100 delete-transaksi-button" data-bs-toggle="modal" data-bs-target="#modalDeleteSuccess">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Transaksi berhasil diubah menjadi Rp. <span id="update-result">0</span></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalDeleteSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Data</h4>
          <p class="color-neutral-80">Transaksi berhasil dihapus</p>
        </div>
      </div>
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