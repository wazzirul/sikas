@extends('sikas/layout/layout')

@section('title', 'Dashboard - Sikas')

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
<script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-dashboard.css')}}">
@endsection

@section('current-pages-title')
Dashboard
@endsection

@section('content')
<div class="row row-card">
  <div class="col-xl-4 col-lg-6 col-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-graduation-cap text-primary avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Pembayaran SPP Hari ini</span>
        <h3 class="card-title color-black mb-2">Rp. 9.500.000</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-piggy-bank text-info avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Tabungan Siswa Hari Ini</span>
        <h3 class="card-title color-black mb-2">Rp. 250.000</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-coins text-danger avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Tabungan Guru Hari ini</span>
        <h3 class="card-title color-black mb-2">Rp. 1.500.000</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-money-bill-transfer text-warning avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Pengajuan Keringanan Hari ini</span>
        <h3 class="card-title color-black mb-2">Rp. 1.750.000</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-sack-dollar text-success avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Pemasukan Dana Lain Hari ini</span>
        <h3 class="card-title color-black mb-2">Rp. 31.500.000</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-school text-dark avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Pengeluaran Hari ini</span>
        <h3 class="card-title color-black mb-2">Rp. 10.500.000</h3>
      </div>
    </div>
  </div>
</div>
<div class="card riwayat-transaksi mt-5">
  <h4 class="color-neutral-100 mb-5">Riwayat Transaksi</h4>
  <div class="nav-align-top mb-4">
      <div class="nav__wrapper">
        <ul class="nav nav-pills mb-3" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pembayaran-spp" aria-controls="navs-pills-pembayaran-spp" aria-selected="true">Pembayaran SPP</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-siswa" aria-controls="navs-pills-tabungan-siswa" aria-selected="false">Tabungan Siswa</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-guru" aria-controls="navs-pills-tabungan-guru" aria-selected="false">Tabungan Guru</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pengajuan-keringanan" aria-controls="navs-pills-pengajuan-keringanan" aria-selected="false">Pengajuan Keringanan</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pemasukan-sumber-lain" aria-controls="navs-pills-pemasukan-sumber-lain" aria-selected="false">Pemasukan</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pengeluaran" aria-controls="navs-pills-pengeluaran" aria-selected="false">Pengeluaran</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-empty-state" aria-controls="navs-pills-empty-state" aria-selected="false">Empty State</button>
          </li>
        </ul>
      </div>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-pembayaran-spp" role="tabpanel">
          <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
            <div class="date-range">
              <div id="date-range-span" class="form-control">
                <span></span>
              </div>
              <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
              <input type="hidden" name="date-range-input" value="" class="" id="date-range-input"/>
            </div>
            <button class="d-flex btn btn-primary gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#modalAddData">
              Filter Data
            </button>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>NIS/NIP</th>
                  <th>Nama</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>2/1/2022</p>
                  </td>
                  <td class="text-medium color-neutral-100">1234123123123123</td>
                  <td>
                    <p class="text-medium text-black">Faisal Adi 'Kelas X TKJ 2'</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">Rp. 150.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/1" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-tabungan-siswa" role="tabpanel">
          <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
            <div class="date-range">
              <div id="date-range-span" class="form-control">
                <span></span>
              </div>
              <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
              <input type="hidden" name="date-range-input" value="" class="" id="date-range-input"/>
            </div>
            <button class="d-flex btn btn-primary gap-2 align-items-center">
              Filter Data
            </button>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>NIS/NIP</th>
                  <th>Nama</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>2/1/2022</p>
                  </td>
                  <td class="text-medium color-neutral-100">1234123123123123</td>
                  <td>
                    <p class="text-medium text-black">Faisal Adi 'Kelas X TKJ 2'</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">Rp. 150.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/1" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-tabungan-guru" role="tabpanel">
          <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
            <div class="date-range">
              <div id="date-range-span" class="form-control">
                <span></span>
              </div>
              <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
              <input type="hidden" name="date-range-input" value="" class="" id="date-range-input"/>
            </div>
            <button class="d-flex btn btn-primary gap-2 align-items-center">
              Filter Data
            </button>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>NIS/NIP</th>
                  <th>Nama</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>2/1/2022</p>
                  </td>
                  <td class="text-medium color-neutral-100">1234123123123123</td>
                  <td>
                    <p class="text-medium text-black">Ibnu Suhaemy 'Kepala Sekolah'</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">Rp. 200.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/1" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-pengajuan-keringanan" role="tabpanel">
          <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
            <div class="date-range">
              <div id="date-range-span" class="form-control">
                <span></span>
              </div>
              <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
              <input type="hidden" name="date-range-input" value="" class="" id="date-range-input"/>
            </div>
            <button class="d-flex btn btn-primary gap-2 align-items-center">
              Filter Data
            </button>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>NIS/NIP</th>
                  <th>Nama</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>2/1/2022</p>
                  </td>
                  <td class="text-medium color-neutral-100">1234123123123123</td>
                  <td>
                    <p class="text-medium text-black">Faisal Adi 'Kelas X TKJ 2'</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">Rp. 150.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/1" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-pemasukan-sumber-lain" role="tabpanel">
          <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
            <div class="date-range">
              <div id="date-range-span" class="form-control">
                <span></span>
              </div>
              <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
              <input type="hidden" name="date-range-input" value="" class="" id="date-range-input"/>
            </div>
            <button class="d-flex btn btn-primary gap-2 align-items-center">
              Filter Data
            </button>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>2/1/2022</p>
                  </td>
                  <td>
                    <p class="text-medium text-black">Dana Bos</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">Rp. 31.150.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/1" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-pengeluaran" role="tabpanel">
          <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
            <div class="date-range">
              <div id="date-range-span" class="form-control">
                <span></span>
              </div>
              <i class="fa-regular fa-calendar-days date-range-icon text-primary"></i>
              <input type="hidden" name="date-range-input" value="" class="" id="date-range-input"/>
            </div>
            <button class="d-flex btn btn-primary gap-2 align-items-center">
              Filter Data
            </button>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>2/1/2022</p>
                  </td>
                  <td>
                    <p class="text-medium text-black">Pembayaran konsumsi rapat koordinasi sosialisasi MUK</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">Rp. 675.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/1" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-empty-state" role="tabpanel">
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Tabungan Siswa Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan siswa.</p>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection