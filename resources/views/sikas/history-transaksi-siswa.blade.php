@extends('sikas/layout/layout')

@section('title', 'History Pembayaran - Sikas')

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
  <span class="text-muted fw-light">Transaksi /</span> History Transaksi Siswa
</p>
<div class="card card--history-transaksi-siswa">
  <div class="card-body">
    <h3 class="color-black">History Transaksi Siswa</h3>
    <div class="table-responsive text-nowrap mt-5">
      <table class="table table-striped" id="history-transaksi-siswa">
        <thead>
          <tr>
            <th class="text-bold">Nama</th>
            <th class="text-bold">NIS</th>
            <th class="text-bold">Kelas</th>
            <th class="text-bold">Jurusan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="color-neutral-100">Adi prahita</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Arsy devano</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Bayu adi</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Chelsie isnain</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Denis danilla</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Eustias harvar</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Felicia anastasya</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Gabriel antonie</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Veny putri</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
            <td class="color-neutral-100">Zevanya austia</td>
            <td class="color-neutral-100">172410103026</td>
            <td class="color-neutral-100">XI</td>
            <td class="color-neutral-100">TKJ 2</td>
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
@endsection
