@extends('sikas/layout/layout')

@section('title', 'Transaksi Pembayaran - Sikas')

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
      <a href="{{route('sikas-transaksi--biaya-penunjang-pendidikan')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-graduation-cap jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Biaya Penunjang Pendidikan</h5>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--tabungan-siswa')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
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
      <a href="{{route('sikas-transaksi--tabungan-guru')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-credit-card jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Pembayaran Tabungan Guru</h5>
    </div>
  </div>
  <!-- <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--pembayaran-history-siswa')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-school jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Histroy Transaksi Siswa</h5>
    </div>
  </div> -->
</div> 
<div class="card riwayat-transaksi mt-5">
  <h4 class="color-neutral-100 mb-5">Riwayat Transaksi</h4>
  <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pembayaran-akademik" aria-controls="navs-pills-pembayaran-akademik" aria-selected="true">Biaya Penunjang Pendidikan</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-sekolah" aria-controls="navs-pills-tabungan-sekolah" aria-selected="false">Tabungan Sekolah</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-empty-state" aria-controls="navs-pills-empty-state" aria-selected="false">Empty State</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-pembayaran-akademik" role="tabpanel">
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
                @foreach($transaksi_akademik as $ta)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($ta->tanggal)->translatedFormat('F, d Y') }}</p>
                  </td>
                  <td class="text-medium color-neutral-100">{{ $ta->Anggota->nis }}</td>
                  <td>
                    <p class="text-medium text-black">{{ $ta->Anggota->nama }}</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">{{ $ta->jumlah }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/{{ $ta->Anggota->id_anggota }}" class="table__link-detail d-flex align-items-center gap-2">
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
        <div class="tab-pane fade" id="navs-pills-tabungan-sekolah" role="tabpanel">
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
            <table class="table table-striped" id="riwayat-tabungan-sekolah">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>NIS/NIP</th>
                  <th>Nama</th>
                  <th>Nominal</th>
                  <th>Jenis Transaksi</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($transaksi_tabungan as $tt)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($tt->tanggal)->translatedFormat('F, d Y') }}</p>
                  </td>
                  <td class="text-medium color-neutral-100">{{ $tt->Anggota->nis ?? $tt->Anggota->nip }}</td>
                  <td>
                    <p class="text-medium text-black">{{ $tt->Anggota->nama }}</p>
                  </td>
                  <td>
                    <p class="text-bold text-black jumlah-pembayaran">{{ $tt->jumlah }}</p>
                  </td>
                  <td>
                    <p class="text-bold text-black text-center">{{ $tt->tipe_transaksi == 2 ? 'Setor' : 'Tarik' }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-end gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/{{ $tt->Anggota->id_anggota }}" class="table__link-detail d-flex align-items-center gap-2">
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
        <div class="tab-pane fade" id="navs-pills-empty-state" role="tabpanel">
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Tabungan Sekolah Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan sekolah.</p>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
