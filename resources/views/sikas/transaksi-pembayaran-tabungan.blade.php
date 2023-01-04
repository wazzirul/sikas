@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran Tabungan - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/pembayaran.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi / Pembayaran /</span> Tabungan
</p>

<div class="card card--pembayaran">
  <div class="card-body">
    <div class="card-item card-item--cari-siswa">
      <label class="text-bold mb-3" for="cari-siswa">Cari Siswa</label>
      <div class="input-group input-group-merge">
        <span class="input-group-text" id="cari-siswa-icon"><i class="bx bx-search"></i></span>
        <input type="text" id="cari-siswa" class="form-control" placeholder="Masukkan nama atau NISN" aria-label="Masukkan nama atau NISN" aria-describedby="cari-siswa-icon">
      </div>
      <div class="cari-siswa">
        <div class="cari-siswa__item">
          <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
            <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
            <div class="d-flex flex-column gap-1">
              <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">Tasya Savella</p>
              <p class="nomor-siswa color-neutral-80">172410103029</p>
            </div>
          </div>
          <div class="d-flex flex-column gap-1">
            <p class="text-bold color-neutral-100">Kelas</p>
            <p class="kelas-siswa color-neutral-80">XI TKJ 2</p>
          </div>
          <a href="#" class="cari-siswa__item-detail">
            <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
          </a>
        </div>
        <div class="cari-siswa__item">
          <div class="d-flex flex-row gap-3 align-items-center cari-siswa__item-nama">
            <i class="fa-regular fa-user cari-siswa__icon color-neutral-100"></i>
            <div class="d-flex flex-column gap-1">
              <p class="text-bold color-neutral-100 cari-siswa__nama-siswa">Anastasya Anzella</p>
              <p class="nomor-siswa color-neutral-80">120293487</p>
            </div>
          </div>
          <div class="d-flex flex-column gap-1">
            <p class="text-bold color-neutral-100">Kelas</p>
            <p class="kelas-siswa color-neutral-80">XI TKJ 3</p>
          </div>
          <a href="#" class="cari-siswa__item-detail">
            <i class="fa-solid fa-chevron-right cari-siswa__item-detail__icon color-neutral-100"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="horizontal-line"></div>
    <div class="card-item">
      <form action="#" class="card-item--detail-dan-form">
        <h3 class="text-bold">Detail Siswa</h3>
        <div class="detail-siswa">
          <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
            <i class="fa-regular fa-user detail-siswa__icon"></i>
            <div class="d-flex flex-column gap-1">
              <h5 class="text-bold color-neutral-100">Anastasya Anzella</h5>
              <p class="nomor-siswa color-neutral-80">120293487</p>
            </div>
          </div>
          <div class="d-flex flex-row justify-content-between align-items-center gap-2 mt-3">
            <div class="d-flex flex-column gap-1">
              <p class="color-neutral-80">Kelas</p>
              <p class="text-bold color-neutral-100">XI TKJ 2</p>
            </div>
            <div class="d-flex flex-column gap-1">
              <p class="color-neutral-80">Total Tabungan</p>
              <h5 class="text-bold text-primary">1.300.000</h5>
            </div>
          </div>
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3">
          <button class="btn btn-lg btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalPenarikan">
            Penarikan
            <i class="fa-solid fa-money-bill"></i>
          </button>
          <button class="btn btn-lg btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalSetoran">
            Setor Tabungan
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="card card--riwayat-tabungan mt-5">
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
        <tbody>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Setor</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Tarik</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Setor</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Tarik</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Setor</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Tarik</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Setor</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Tarik</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <p class="text-bold color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
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
        <form action="#">
          <div class="mt-5">
            <label for="nominalPenarikan" class="form-label">Nominal Penarikan</label>
            <input type="text" class="form-control" id="nominalPenarikan" placeholder="Rp. 0.00">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalPenarikanSuccess">Tarik Sekarang</button>
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
        <form action="#">
          <div class="mt-5">
            <label for="nominalTabungan" class="form-label">Nominal Tabungan</label>
            <input type="text" class="form-control" id="nominalTabungan" placeholder="Rp. 0.00">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalSetoranSuccess">Setor Sekarang</button>
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
