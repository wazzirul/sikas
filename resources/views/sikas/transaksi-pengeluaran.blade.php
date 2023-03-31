@extends('sikas/layout/layout')

@section('title', 'Transaksi Pengeluaran - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/daterangepicker/daterangepicker.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/unduh-format-data.js')}}"></script>
<script src="{{asset('assets/js/pages/pengeluaran.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-pemasukan-pengeluaran.css')}}">
@endsection

@section('current-pages-title')
  Transaksi
@endsection

@section('content')
<div class="card-body__header d-flex flex-row justify-content-between align-items-start gap-1 mb-5">
  <p class="fw-bold mb-5">
    <span class="text-muted fw-light">Transaksi /</span> Pengeluaran
  </p>
  <div class="d-flex flex-row justify-center align-items-center gap-3">
    <button onclick="do_dl_pengeluaran();" class="btn bg-lg btn-outline-dark btn-unduh-format d-flex gap-2 align-items-center w-max-content ml-auto">
        Unduh Contoh Format Import Data
        <i class="fa-solid fa-download"></i>
    </button>
    <form action="/transaksi/importPengeluaran" id="importForm" class="form-upload-siswa" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
      <input type="file" name="file" id="pengeluaran-upload-file" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
      <label for="pengeluaran-upload-file" class="btn bg-lg btn-outline-primary btn-import-transaksi d-flex gap-2 align-items-center w-max-content ml-auto">
          Import Transaksi Pengeluaran
          <i class="fa-solid fa-arrow-up-from-bracket"></i>
      </label>
    </form>
  </div>
</div>
<div class="card card--pemasukan-pengeluaran">
  <div class="pemasukan-pengeluaran__form">
    <h4 class="text-bold color-black mb-4">Form Pengeluaran</h4>
    <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
    <div class="pengajuan-pengeluaran-form">
      <div class="mt-3 pengajuan-pengeluaran-form__wrap">
        <div class="">
          <label for="nominalPengeluaran" class="form-label text-bold color-black">Nominal Pengeluaran</label>
          <input type="text" min="0" autocomplete="off" class="form-control" name="nominalPengeluaran" id="nominalPengeluaran" placeholder="0.00">
        </div>
        <div class="">
          <label for="tanggalPengeluaran" class="form-label text-bold color-black">Tanggal Pengeluaran</label>
          <input type="text" name="tanggalPengeluaran" id="tanggalPengeluaran" class="form-control" />
        </div>
      </div>
      <div class="mt-3">
        <label for="keterangan" class="form-label text-bold color-black">Keterangan</label>
        <textarea class="form-control" autocomplete="off" id="keterangan" name="keterangan" rows="6" placeholder="Masukan keterangan pengeluaran"></textarea>
      </div>
      <button class="btn btn-primary pengajuan-pemasukan-button mt-5" data-bs-toggle="modal" data-bs-target="#modalPengajuanPengeluaran">Setor Pengeluaran</button>
    </div>
  </div>
  <div class="border-line"></div>
  <div class="riwayat-pemasukan">
    <h4 class="text-bold color-black mb-4">Riwayat Pengeluaran</h4>    
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="riwayat-pengeluaran">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama Teller</th>
            <th>Keterangan</th>
            <th>Nominal Pengeluaran</th>
            <th>Status</th>
            <th>Konfrimasi</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($transaksi as $t)
          <tr>
            <td>
              <p class="text-medium color-neutral-100">{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('F, d Y') }}</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $t->Admin->nama }}</p>              
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $t->nama_transaksi }}</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-transaksi">{{ $t->jumlah }}</p>
            </td>
            <td>
            <p class="text-bold color-neutral-100">{{ $t->approved == 1 ? 'Sudah Dikonfirmasi' : 'Butuh Konfirmasi Admin' }}</p>
            </td>
            <td>
              @if(Session::get('tipe_user') == 1 && $t->approved == 0)
                <a href="#" class="btn btn-success approve-button" data-jumlah="{{ $t->jumlah }}" onClick="changeTransaksi({{$t->id_transaksi}})" data-bs-toggle="modal" data-bs-target="#modalConfrimData">
                  Konfrimasi
                </a>
              @endif
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-info gap-1" onClick="changeTransaksi({{$t->id_transaksi}})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail text-danger gap-1" onClick="changeTransaksi({{$t->id_transaksi}})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalConfrimData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column text-center justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Konfrimasi Transaksi Pengeluaran</h4>
          <p class="">Apakah anda yakin akan melakukan pengeluaran sejumlah <br> 
            " <span class="text-primary text-bold modal--transaksi__nominal-penarikan">Rp. 25.000</span> " <br>
            <small class="text-danger text-extra-bold font-half">*Pengeluaran yang telah dikonfrimasi tidak bisa diubah / dihapus datanya, pastikan data pengeluaran sudah benar!</small>
          </p>
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-success w-100 confirm-transaksi-button" data-bs-toggle="modal" data-bs-target="#modalConfrimSuccess">Konfrimasi</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Edit Transaksi Pengeluaran</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <div class="mt-5">
          <label for="jumlah-pembayaran" class="form-label">Jumlah Pengeluaran</label>
          <input type="hidden" id="id_transaksi" />
          <input type="text" class="form-control" id="jumlah-pembayaran" placeholder="Rp. 0.00">
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
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
          <h4 class="color-black text-bold text-center">Hapus Transaksi Pengeluaran</h4>
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
          <button class="btn btn-danger w-100 delete-transaksi-button" data-bs-toggle="modal" data-bs-target="#modalDeleteSuccess">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalConfrimSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Konfrimasi Data Pengeluaran</h4>
          <p class="color-neutral-80">Transaksi pengeluaran berhasil dikonfrimasi</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalPengajuanPengeluaran" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Pengeluaran</h4>
          <p class="color-neutral-80">Anda bisa melihat pengeluaran yang baru saja anda tambahkan pada riwayat pengeluaran.</p>
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
@endsection
