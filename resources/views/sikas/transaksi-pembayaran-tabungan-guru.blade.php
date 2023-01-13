@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran Tabungan - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/terbilangjs/terbilang.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/print-receipt.js')}}"></script>
<script src="{{asset('assets/js/pages/pembayaran-tabungan-guru.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi / Tabungan /</span> Guru
</p>

<div class="card card--pembayaran">
  <div class="card-body">
    <h3 class="text-bold mb-4">Form Pembayaran Tabungan Guru</h3>
    <div class="card-body__wrapper">
    <div class="card-item card-item--cari-siswa">
      <label class="text-bold mb-3" for="cari-siswa">Cari Guru</label>
      <div class="input-group input-group-merge">
        <span class="input-group-text" id="cari-siswa-icon"><i class="bx bx-search"></i></span>
        <input type="text" id="cari-siswa" class="form-control" placeholder="Masukkan nama atau NIP" aria-label="Masukkan nama atau NIP" aria-describedby="cari-siswa-icon">
        <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
      </div>
      <div class="cari-siswa">
        @foreach($anggota as $a)
        <div class="cari-siswa__item" data-id="{{ $a->id_anggota }}">
          <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
            <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
            <div class="d-flex flex-column gap-1">
              <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">{{ $a->nama }}</p>
              <p class="nomor-siswa color-neutral-80">{{ $a->nama }}</p>
            </div>
          </div>
          <div class="d-flex flex-column gap-1">
            <p class="text-bold color-neutral-100">Jabatan</p>
            <p class="kelas-siswa color-neutral-80">{{ $a->Jabatan->jabatan ?? 'Guru' }}</p>
          </div>
          <a href="#" class="cari-siswa__item-detail">
            <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
          </a>
        </div>
        @endforeach
        <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
          <img src="{{asset('assets/img/sikas/empty-illustration-2.png')}}" alt="">
          <h4 class="text-bold color-neutral-100">Belum Ada Pencarian</h4>
          <p class="color-neutral-80">Masukkan nama lengkap Guru / Karyawan untuk melakukan pencarian.</p>
        </div>
      </div>
    </div>
    <div class="horizontal-line"></div>
    <div class="card-item">
      <div class="card-item--detail-dan-form">
        <div class="detail-siswa">
          <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
            <i class="fa-regular fa-user detail-siswa__icon"></i>
            <div class="d-flex flex-column gap-1">
              <h5 class="text-bold color-neutral-100 detail-nama">Nama Guru</h5>
              <p class="nomor-siswa color-neutral-80 detail-nip">-</p>
            </div>
          </div>
          <div class="d-flex flex-row justify-content-between align-items-center gap-2 mt-3">
            <div class="d-flex flex-column gap-1">
              <p class="color-neutral-80">Jabatan</p>
              <p class="text-bold color-neutral-100 detail-jabatan">-</p>
            </div>
            <div class="d-flex flex-column gap-1">
              <p class="color-neutral-80">Total Tabungan</p>
              <h5 class="text-bold text-primary detail-tabungan">-</h5>
            </div>
          </div>
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3">
          <button class="btn btn-lg btn-outline-primary w-100 penarikan-button disabled" data-bs-toggle="modal" data-bs-target="#modalPenarikan">
            Penarikan
            <i class="fa-solid fa-money-bill"></i>
          </button>
          <button class="btn btn-lg btn-primary w-100 setoran-button disabled" data-bs-toggle="modal" data-bs-target="#modalSetoran">
            Setor Tabungan
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>

<div class="card card--riwayat-tabungan mt-5 d-none">
  <h4 class="color-neutral-100 mb-5">Riwayat Tabungan</h4>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="riwayat-tabungan">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jenis Transaksi</th>
            <th>Jumlah Nominal</th>
            <th>Mutasi</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="list-riwayat-tabungan">

        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalPenarikan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Penarikan Tabungan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form id="form-tarik-tabungan" action="/query/penarikanTabunganSiswa" method="POST">
          {{ csrf_field() }}
          <div class="mt-5">
            <label for="nominalPenarikan" class="form-label">Nominal Penarikan</label>
            <input type="hidden" name="id_anggota" class="id_anggota_input" id="id_anggota_penarikan" />
            <input type="text" class="form-control" name="nominal" id="nominalPenarikan" placeholder="Rp. 0.00">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary w-100 post-penarikan-tabungan-button" data-bs-toggle="modal" data-bs-target="#modalPenarikanSuccess">Tarik Sekarang</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalSetoran" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Setor Tabungan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form id="form-setor-tabungan" action="/query/setorTabunganSiswa" method="POST">
          {{ csrf_field() }}
          <div class="mt-5">
            <label for="nominalTabungan" class="form-label">Nominal Tabungan</label>
            <input type="hidden" name="id_anggota" class="id_anggota_input" id="id_anggota_setoran" />
            <input type="text" class="form-control" name="nominal" id="nominalTabungan" placeholder="Rp. 0.00">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary w-100 post-setoran-tabungan-button" data-bs-toggle="modal" data-bs-target="#modalSetoranSuccess">Setor Sekarang</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalPenarikanSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Melakukan Penarikan</h4>
          <p class="color-neutral-80">Anda bisa melihat detail penarikan yang baru saja anda lakukan di halaman home.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalSetoranSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Melakukan Setoran</h4>
          <p class="color-neutral-80">Anda bisa melihat detail setoran yang baru saja anda lakukan di halaman home.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection