@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran - Sikas')

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
  <span class="text-muted fw-light">Transaksi /</span> Pembayaran
</p>
<div class="jenis-pembayaran">
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--pembayaran-akademik')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-graduation-cap jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Pembayaran Uang Akademik</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--pembayaran-tabungan-siswa')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-regular fa-credit-card jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Pembayaran Tabungan Siswa</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--pembayaran-tabungan-guru')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-credit-card jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Pembayaran Tabungan Guru</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--pembayaran-history-siswa')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-school jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Histroy Transaksi Siswa</h5>
    </div>
  </div>
</div>
<div class="card riwayat-transaksi mt-5">
  <h4 class="color-neutral-100 mb-5">Riwayat Transaksi</h4>
  <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pembayaran-akademik" aria-controls="navs-pills-pembayaran-akademik" aria-selected="true">Pembayaran Akademik</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-sekolah" aria-controls="navs-pills-tabungan-sekolah" aria-selected="false">Tabungan Sekolah</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-pembayaran-akademik" role="tabpanel">
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>NISN/NIP</th>
                  <th>Nama</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Aldi taher</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Ibnu setiaji</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Tasya savella</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Ibnu setiaji</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Alfian Bayu</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Ibnu Setiaji</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
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
        <div class="tab-pane fade" id="navs-pills-tabungan-sekolah" role="tabpanel">
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-tabungan-sekolah">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>NISN/NIP</th>
                  <th>Nama</th>
                  <th>Nominal</th>
                  <th>Jenis Transaksi</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Aldi taher</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <p class="text-bold text-black text-center">Setor</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Ibnu setiaji</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <p class="text-bold text-black text-center">Tarik</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Tasya savella</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <p class="text-bold text-black text-center">Setor</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Ibnu setiaji</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <p class="text-bold text-black text-center">Tarik</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Alfian Bayu</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <p class="text-bold text-black text-center">Setor</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
                        Lihat Detail
                        <i class="fa-solid fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>January, 02 2023</p>
                  </td>
                  <td class="text-medium color-neutral-100">172410103029</td>
                  <td>
                    <p class="text-medium text-black">Ibnu Setiaji</p>
                  </td>
                  <td>
                    <p class="text-bold text-black">Rp. 700.000</p>
                  </td>
                  <td>
                    <p class="text-bold text-black text-center">Tarik</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="{{route('sikas-transaksi--pembayaran-history-siswa-detail')}}" class="table__link-detail d-flex align-items-center gap-2">
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
      </div>
    </div>
</div>
@endsection
