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
  <!-- <div class="card">
    <div class="card-body">
      <a href="" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-coins jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Pembayaran Tabungan Guru</h5>
    </div>
  </div> -->
  <div class="card">
    <div class="card-body">
      <a href="{{route('sikas-transaksi--tabungan-umum')}}" class="d-flex justify-content-between align-items-center gap-3 jenis-pembayaran__link">
        <div class="jenis-pembayaran__icon-wrap">
          <i class="fa-solid fa-wallet jenis-pembayaran__icon"></i>
        </div>
        <i class="fa-solid fa-chevron-right jenis-pembayaran__icon jenis-pembayaran__icon--link"></i>
      </a>
      <h5 class="text-bold color-black mt-5">Pembayaran Tabungan Umum</h5>
    </div>
  </div>
</div> 
<div class="card konfirmasi-pengeluaran mt-5">
  <h4 class="color-neutral-100 mb-5">Konfirmasi Transaksi Pengeluaran Tabungan</h4>
  <div class="table-responsive text-nowrap tabel-siswa">
    <table class="table table-striped" id="konfirmasi-tabungan">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Nama Teller</th>
          <th>No Tabungan</th>
          <th>Nama Tabungan</th>
          <th>Nominal Pengeluaran</th>
          <th>Mutasi Tabungan</th>
          <th>Status</th>
          @if(Session::get('tipe_user') == 1)
          <th>Actions</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($tabungan_perlu_approve as $tpa)
        <tr>
          <td>
            <p>{{ \Carbon\Carbon::parse($tpa->tanggal)->translatedFormat('F, d Y') }}</p>
          </td>
          <td class="text-medium color-neutral-100">{{ $tpa->Admin->nama }}</td>

          @if($tpa->id_tabungan_umum == null)
          <td class="text-medium color-neutral-100">{{ $tpa->Anggota->nis }}</td>
          <td>
            <p class="text-medium text-black">{{ $tpa->Anggota->nama }} 'Kelas {{ $tpa->Anggota->Kelas->nama }} {{ $tpa->Anggota->Jurusan->nama }} {{ $tpa->Anggota->nomor_kelas }}'</p>
          </td>
          @else
          <td class="text-medium color-neutral-100">{{ $tpa->TabunganUmum->nomor_tabungan }}</td>
          <td>
            <p class="text-medium text-black">{{ $tpa->TabunganUmum->nama_tabungan }}</p>
          </td>
          @endif
          
          <td>
            <p class="text-bold text-black jumlah-pembayaran">{{ $tpa->jumlah }}</p>
          </td>
          <td>
            <p class="text-bold text-black jumlah-pembayaran">{{ $tpa->mutasi }}</p>
          </td>
          <td>
              <p class="text-bold text-danger">Butuh Konfirmasi Admin</p>
          </td>
          @if(Session::get('tipe_user') == 1)
          <td>
            <div class="d-flex align-items-center justify-content-start gap-3">
              <a href="#" class="btn btn-success approve-button" data-jumlah="{{ $tpa->jumlah }}" data-tipe_tabungan="{{ $tpa->id_tabungan_umum == null ? 'siswa' : 'umum' }}" data-id_tabungan="{{ $tpa->id_tabungan_umum == null ? $tpa->id_anggota : $tpa->id_tabungan_umum }}" onClick="changeTransaksi({{ $tpa->id_transaksi }})" data-bs-toggle="modal" data-bs-target="#modalConfrimData">Konfirmasi</a>
            </div>
          </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
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
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-umum" aria-controls="navs-pills-tabungan-umum" aria-selected="false">Tabungan Umum</button>
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

      <div class="tab-pane fade" id="navs-pills-tabungan-umum" role="tabpanel">
        @if(count($tabungan_umum) != 0)
        <div class="table-responsive text-nowrap tabel-umum">
          <table class="table table-striped" id="riwayat-tabungan-umum">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Teller</th>
                <th>Nomor Tabungan</th>
                <th>Nama Tabungan</th>
                <th>Nominal</th>
                <!-- <th>Actions</th> -->
              </tr>
            </thead>
            <tbody id="tbody-tabungan-umum">
            @foreach($tabungan_umum as $tu)
              <tr>
                <td>
                  <p>{{ \Carbon\Carbon::parse($tu->tanggal)->translatedFormat('F, d Y') }}</p>
                </td>
                <td class="text-medium color-neutral-100">{{ $tu->Admin->nama }}</td>
                <td class="text-medium color-neutral-100">{{ $tu->TabunganUmum->nomor_tabungan }}</td>
                <td>
                  <p class="text-medium text-black">{{ $tu->TabunganUmum->nama_tabungan }}</p>
                </td>
                <td>
                  <p class="text-bold text-black jumlah-pembayaran">{{ $tu->jumlah }}</p>
                </td>
                <!-- <td>
                  <div class="d-flex align-items-center justify-content-start gap-3">
                    <a href="/transaksi/tabungan/umum" class="table__link-detail d-flex align-items-center gap-2">
                      Lihat Detail
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </div>
                </td> -->
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state-umum">
          <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
          <h4 class="text-bold color-neutral-100">Data Tabungan Umum Kosong</h4>
          <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan umum.</p>
        </div>
        @endif
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
          <h4 class="color-black text-bold text-center">Konfirmasi Transaksi Penarikan</h4>
          <p class="">Apakah anda yakin akan melakukan penarikan sejumlah <br> 
            " <span class="text-primary text-bold modal--transaksi__nominal-penarikan">Rp. 25.000</span> "<br>
            <small class="text-danger text-extra-bold font-half">*Penarikan yang telah dikonfirmasi tidak bisa diubah / dihapus datanya, pastikan data penarikan sudah benar!</small>
          </p>
          <input type="hidden" id="id_transaksi" />
          <input type="hidden" id="id_anggota_setoran" />
          <input type="hidden" id="id_tabungan_umum_setoran" />
          <input type="hidden" id="tipe_tabungan_setoran" />
          <input type="hidden" id="ctoken" value="{{ csrf_token() }}">

        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-success w-100 confirm-transaksi-button" data-bs-toggle="modal" data-bs-target="#modalConfirmSuccess">Konfirmasi</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi fade" id="modalConfirmSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Konfirmasi Transaksi Data</h4>
          <p class="color-neutral-80">Transaksi berhasil dikonfirmasi</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
