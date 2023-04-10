@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran Tabungan - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/choices/styles/choices.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/terbilangjs/terbilang.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/choices/scripts/choices.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/print-receipt.js')}}"></script>
<script src="{{asset('assets/js/unduh-format-data.js')}}"></script>
<script src="{{asset('assets/js/pages/pembayaran-tabungan-umum.js')}}"></script>
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
    <span class="text-muted fw-light">Transaksi / Tabungan /</span> Umum
  </p>
  <div class="d-flex flex-row justify-center align-items-center gap-3">
    <button onclick="do_dl_tabungan_umum();" class="btn bg-lg btn-outline-dark btn-unduh-format d-flex gap-2 align-items-center w-max-content ml-auto">
        Unduh Contoh Format Import Data
        <i class="fa-solid fa-download"></i>
    </button>
    <form action="/transaksi/importTabunganSiswa" id="importForm" class="form-upload-siswa" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
      <input type="file" name="file" id="tabungan-upload-file" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
      <label for="tabungan-upload-file" class="btn bg-lg btn-outline-primary btn-import-transaksi d-flex gap-2 align-items-center w-max-content ml-auto">
          Import Transaksi Tabungan Umum
          <i class="fa-solid fa-arrow-up-from-bracket"></i>
      </label>
    </form>
  </div>
</div>

<div class="card card--pembayaran">
  <div class="card-body">
    <div class="d-flex flex-row justify-content-between align-items-center mb-4">
      <h3 class="text-bold">Form Pembayaran Tabungan Umum</h3>
      <button class="btn btn-lg btn-primary tabungan-umum-baru-button" data-bs-toggle="modal" data-bs-target="#modalBukaTabunganBaru">
        Buka Tabungan Baru
        <i class="fa-solid fa-plus"></i>
      </button>
    </div>
    <div class="card-body__wrapper">
      <div class="card-item card-item--cari-siswa">
        <label class="text-bold mb-3" for="cari-siswa">Cari Data Tabungan</label>
        <div class="input-group input-group-merge">
          <span class="input-group-text" id="cari-siswa-icon"><i class="bx bx-search"></i></span>
          <input type="text" autocomplete="off" id="cari-siswa" class="form-control" placeholder="Masukkan Nama atau No. Buku Tabungan" aria-label="Masukkan nama atau NIS" aria-describedby="cari-siswa-icon">
          <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
        </div>
        <div class="cari-siswa">
          <a href="#!" class="cari-siswa__item" data-id="${value.id_anggota}">
            <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
              <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
              <div class="d-flex flex-column gap-1">
                  <p class="text-bold cari-siswa__nama-siswa text-primary">Kelas XII OTR 3</p>
                  <p class="text-bold color-neutral-100 nomor-siswa">0001</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-1">
              <p class="kelas-siswa color-neutral-80">Jabatan / Kelas</p>
              <p class="text-bold text-info">XII OTR 3</p>
            </div>
            <div href="#" class="cari-siswa__item-detail">
              <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
            </div>
          </a>
          <a href="#!" class="cari-siswa__item" data-id="${value.id_anggota}">
            <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
              <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
              <div class="d-flex flex-column gap-1">
                  <p class="text-bold cari-siswa__nama-siswa text-primary">Masjid</p>
                  <p class="text-bold color-neutral-100 nomor-siswa">0004</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-1">
              <p class="kelas-siswa color-neutral-80">Jabatan / Kelas</p>
              <p class="text-bold text-info">Umum</p>
            </div>
            <div href="#" class="cari-siswa__item-detail">
              <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
            </div>
          </a>
          <a href="#!" class="cari-siswa__item" data-id="${value.id_anggota}">
            <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
              <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
              <div class="d-flex flex-column gap-1">
                  <p class="text-bold cari-siswa__nama-siswa text-primary">Kelas XI TKJ 2</p>
                  <p class="text-bold color-neutral-100 nomor-siswa">0002</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-1">
              <p class="kelas-siswa color-neutral-80">Jabatan / Kelas</p>
              <p class="text-bold text-info">XI TKJ 2</p>
            </div>
            <div href="#" class="cari-siswa__item-detail">
              <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
            </div>
          </a>
          <a href="#!" class="cari-siswa__item" data-id="${value.id_anggota}">
            <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
              <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
              <div class="d-flex flex-column gap-1">
                  <p class="text-bold cari-siswa__nama-siswa text-primary">Kelas X TKJ 2</p>
                  <p class="text-bold color-neutral-100 nomor-siswa">0003</p>
              </div>
            </div>
            <div class="d-flex flex-column gap-1">
              <p class="kelas-siswa color-neutral-80">Jabatan / Kelas</p>
              <p class="text-bold text-info">X TKJ 2</p>
            </div>
            <div href="#" class="cari-siswa__item-detail">
              <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
            </div>
          </a>
        </div>
      </div>
      <div class="horizontal-line"></div>
      <div class="card-item">
        <div class="card-item--detail-dan-form">
          <div class="detail-siswa">
            <div class="d-flex flex-row justify-content-between align-items-center gap-2">
              <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
                <i class="fa-regular fa-user detail-siswa__icon"></i>
                <div class="d-flex flex-column gap-1">
                  <h5 class="text-bold color-neutral-100 detail-nama">Nama Tabungan</h5>
                  <p class="nomor-siswa color-super-black detail-nis">-</p>
                </div>
              </div>
              <div class="d-flex flex-column detail-siswa__status-siswa">
                <p class="color-neutral-100">Jabatan / Kelas</p>
                <p class="text-bold detail-status-siswa">
                  <span class="text-success">-</span>
                </p>
              </div>
            </div>
            <div class="d-flex flex-row justify-content-between align-items-center gap-2 mt-3">
              <div class="d-flex flex-column gap-1">
                <p class="color-neutral-80">No. Buku Tabungan</p>
                <p class="text-bold color-neutral-100 detail-kelas">-</p>
              </div>
              <div class="d-flex flex-column gap-1 detail-siswa__total-tabungan">
                <p class="color-neutral-80">Total Tabungan</p>
                <h5 class="text-bold text-primary detail-tabungan">0</h5>
              </div>
            </div>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3">
            <button class="btn btn-lg btn-outline-primary w-100 penarikan-button" data-bs-toggle="modal" data-bs-target="#modalPenarikan">
              Penarikan
              <i class="fa-solid fa-money-bill"></i>
            </button>
            <button class="btn btn-lg btn-primary w-100 setoran-button" data-bs-toggle="modal" data-bs-target="#modalSetoran">
              Setor Tabungan
              <i class="fa-solid fa-plus"></i>
            </button>
          </div>
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration-2.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Belum Ada Tabungan yang Dipilih</h4>
            <p class="color-neutral-80">Lakukan pencarian / pilih salah satu data tabungan.</p>
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
      <table class="table table-striped" id="riwayat-tabungan" data-username="{{ \Session::get('nama') }}">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jenis Transaksi</th>
            <th>Nama Teller</th>
            <th>Jumlah Nominal</th>
            <th>Mutasi</th>
            <th>Status</th>
            <th>Konfrimasi</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="list-riwayat-tabungan">
        </tbody>
      </table>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state history-empty d-none">
      <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
      <h4 class="text-bold color-neutral-100">Data Tabungan Kosong</h4>
      <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan.</p>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalBukaTabunganBaru" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Buka Tabungan Baru</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form id="form-setor-tabungan" action="#" method="get">
          {{ csrf_field() }}
          <div class="mt-5">
            <label for="nomorTabungan" class="form-label">Nomor Tabungan</label>
            <input type="hidden" name="id_anggota" class="id_anggota_input" id="id_anggota_setoran" />
            <input type="text" class="form-control" name="nominal" id="nomorTabungan" value="0005" disabled>
          </div>
          <div class="mt-5">
            <label for="namaTabungan" class="form-label">Nama Tabungan</label>
            <input type="text" class="form-control" name="nominal" id="namaTabungan" placeholder="Nama Tabungan...">
          </div>
          <div class="mt-5">
            <label for="jabatanKelas" class="form-label">Jabatan / Kelas</label>
            <!-- AUTO COMPLETE DROPDOWN -->
            <select id="jabatanKelas" class="selectpicker form-control choices-sikas">
              <option value="Umum">Umum</option>
              <option value="Guru">Guru</option>
              <option value="XII OTR 1">XII OTR 1</option>
              <option value="XII OTR 2">XII OTR 2</option>
              <option value="XII OTR 3">XII OTR 3</option>
              <option value="XII TBSM 1">XII TBSM 1</option>
              <option value="XII TBSM 2">XII TBSM 2</option>
              <option value="XII TBSM 3">XII TBSM 3</option>
              <option value="XII TKJ 1">XII TKJ 1</option>
              <option value="XII TKJ 2">XII TKJ 2</option>
              <option value="XII TKJ 3">XII TKJ 3</option>
              <option value="XII TKR 1">XII TKR 1</option>
              <option value="XII TKR 2">XII TKR 2</option>
              <option value="XII TKR 3">XII TKR 3</option>
              <option value="XI OTR 1">XI OTR 1</option>
              <option value="XI OTR 2">XI OTR 2</option>
              <option value="XI OTR 3">XI OTR 3</option>
              <option value="XI TBSM 1">XI TBSM 1</option>
              <option value="XI TBSM 2">XI TBSM 2</option>
              <option value="XI TBSM 3">XI TBSM 3</option>
              <option value="XI TKJ 1">XI TKJ 1</option>
              <option value="XI TKJ 2">XI TKJ 2</option>
              <option value="XI TKJ 3">XI TKJ 3</option>
              <option value="XI TKR 1">XI TKR 1</option>
              <option value="XI TKR 2">XI TKR 2</option>
              <option value="XI TKR 3">XI TKR 3</option>
              <option value="X OTR 1">X OTR 1</option>
              <option value="X OTR 2">X OTR 2</option>
              <option value="X OTR 3">X OTR 3</option>
              <option value="X TBSM 1">X TBSM 1</option>
              <option value="X TBSM 2">X TBSM 2</option>
              <option value="X TBSM 3">X TBSM 3</option>
              <option value="X TKJ 1">X TKJ 1</option>
              <option value="X TKJ 2">X TKJ 2</option>
              <option value="X TKJ 3">X TKJ 3</option>
              <option value="X TKR 1">X TKR 1</option>
              <option value="X TKR 2">X TKR 2</option>
              <option value="X TKR 3">X TKR 3</option>
            </select>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalBukaTabunganBaruSuccess">Buat Tabungan</button>
          </div>
        </form>
      </div>
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
            <input type="hidden" id="session_admin" value="{{ Session::get('tipe_user') }}" />
            <input type="text" class="form-control" name="nominal" id="nominalPenarikan" placeholder="Rp. 0.00">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
            <button type="hidden" class="d-none" id="button_penarikan_sukses" data-bs-toggle="modal" data-bs-target="#modalPenarikanSuccess"></button>
            <button type="submit" class="btn btn-primary w-100 post-penarikan-tabungan-button">Tarik Sekarang</button>
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
<div class="modal modal--transaksi modal--transaksi-tabungan fade" id="modalConfrimData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column text-center justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Konfrimasi Transaksi Penarikan</h4>
          <p class="">Apakah anda yakin akan melakukan penarikan sejumlah <br> 
            " <span class="text-primary text-bold modal--transaksi__nominal-penarikan">Rp. 25.000</span> "<br>
            <small class="text-danger text-extra-bold font-half">*Penarikan yang telah dikonfrimasi tidak bisa diubah / dihapus datanya, pastikan data penarikan sudah benar!</small>
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
<button type="hidden" class="d-none" id="button_penarikan_gagal" data-bs-toggle="modal" data-bs-target="#modalPenarikanGagal"></button>
<div class="modal modal--transaksi fade" id="modalPenarikanGagal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-xmark icon-success text-danger"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Error! Anda Gagal Melakukan Penarikan</h4>
          <p class="color-neutral-80">Saldo Tabungan anda tidak cukup untuk melakukan penarikan.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalBukaTabunganBaruSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Membuat Tabungan</h4>
          <p class="color-neutral-80">Anda bisa mulai menabung sekarang.</p>
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

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalConfrimSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Konfrimasi Transaksi Data</h4>
          <p class="color-neutral-80">Transaksi berhasil dikonfrimasi</p>
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