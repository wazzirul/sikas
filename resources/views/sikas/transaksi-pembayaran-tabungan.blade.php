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
<script src="{{asset('assets/js/pages/pembayaran-tabungan.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi /</span> Tabungan
</p>
<div class="jenis-pembayaran">
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--tabungan-siswa')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-piggy-bank jenis-pembayaran__icon"></i>
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
          <i class="fa-solid fa-coins jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Pembayaran Tabungan Guru</h5>
    </div>
  </div>
</div> 
<div class="card riwayat-transaksi mt-5">
  <h4 class="color-neutral-100 mb-5">Riwayat Transaksi</h4>
  <div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
      <li class="nav-item">
        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-siswa" aria-controls="navs-pills-tabungan-siswa" aria-selected="true">Tabungan Siswa</button>
      </li>
      <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-guru" aria-controls="navs-pills-tabungan-guru" aria-selected="false">Tabungan Guru</button>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" id="navs-pills-tabungan-siswa" role="tabpanel">
        @if(count($tabungan_siswa) != 0)
        <div class="table-responsive text-nowrap tabel-siswa">
          <table class="table table-striped" id="riwayat-tabungan-siswa">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Teller</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Nominal</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="tbody-tabungan-siswa">
              @foreach($tabungan_siswa as $ts)
              <tr>
                <td>
                  <p>{{ \Carbon\Carbon::parse($ts->tanggal)->translatedFormat('F, d Y') }}</p>
                </td>
                <td class="text-medium color-neutral-100">{{ $ts->Admin->nama }}</td>
                <td class="text-medium color-neutral-100">{{ $ts->Anggota->nis }}</td>
                <td>
                  <p class="text-medium text-black">{{ $ts->Anggota->nama }} 'Kelas {{ $ts->Anggota->Kelas->nama }} {{ $ts->Anggota->Jurusan->nama }} {{ $ts->Anggota->nomor_kelas }}'</p>
                </td>
                <td>
                  <p class="text-bold text-black jumlah-pembayaran">{{ $ts->jumlah }}</p>
                </td>
                <td>
                  <div class="d-flex align-items-center justify-content-start gap-3">
                    <a href="/transaksi/history-transaksi-siswa/detail/{{ $ts->Anggota->id_anggota }}" class="table__link-detail d-flex align-items-center gap-2">
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
        @else
        <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state-siswa">
          <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
          <h4 class="text-bold color-neutral-100">Data Tabungan Siswa Kosong</h4>
          <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan siswa.</p>
        </div>
        @endif
      </div>

      <div class="tab-pane fade" id="navs-pills-tabungan-guru" role="tabpanel">
        @if(count($tabungan_guru) != 0)
        <div class="table-responsive text-nowrap tabel-guru">
          <table class="table table-striped" id="riwayat-tabungan-guru">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Teller</th>
                <th>NIP</th>
                <th>Nama Guru</th>
                <th>Nominal</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="tbody-tabungan-guru">
            @foreach($tabungan_guru as $tg)
              <tr>
                <td>
                  <p>{{ \Carbon\Carbon::parse($tg->tanggal)->translatedFormat('F, d Y') }}</p>
                </td>
                <td class="text-medium color-neutral-100">{{ $tg->Admin->nama }}</td>
                <td class="text-medium color-neutral-100">{{ $tg->Anggota->nip }}</td>
                <td>
                  <p class="text-medium text-black">{{ $tg->Anggota->nama }} 'Jabatan {{ $tg->Anggota->Jabatan != null ? $tg->Anggota->Jabatan->nama : "Guru" }}'</p>
                </td>
                <td>
                  <p class="text-bold text-black jumlah-pembayaran">{{ $tg->jumlah }}</p>
                </td>
                <td>
                  <div class="d-flex align-items-center justify-content-start gap-3">
                    <a href="/transaksi/history-transaksi-siswa/detail/{{ $tg->Anggota->id_anggota }}" class="table__link-detail d-flex align-items-center gap-2">
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
        @else
        <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state-guru">
          <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
          <h4 class="text-bold color-neutral-100">Data Tabungan Guru Kosong</h4>
          <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan guru.</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
