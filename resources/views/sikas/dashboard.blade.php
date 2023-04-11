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
<script src="{{asset('assets/vendor/libs/terbilangjs/terbilang.min.js')}}"></script>
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
<p class="badge bg-primary d-flex gap-2 align-items-center badge-date mb-4">
  <i class="fa-regular fa-calendar badge-icon"></i>
  <span></span>
  {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
</p>
<div class="row row-card">
  <div class="col-xl-4 col-lg-6 col-md-6 col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-graduation-cap text-primary avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Biaya Penunjang Pendidikan Hari ini</span>
        <h3 class="card-title color-black mb-2 nominal-transaksi">{{ $transaksi_spp }}</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-piggy-bank text-info avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Tabungan Siswa Hari Ini</span>
        <h3 class="card-title color-black mb-2 nominal-transaksi">{{ $tabungan_siswa }}</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-coins text-danger avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Tabungan Guru Hari ini</span>
        <h3 class="card-title color-black mb-2 nominal-transaksi">{{ $tabungan_guru }}</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-sack-dollar text-success avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Pengajuan Penambahan Hari ini</span>
        <h3 class="card-title color-black mb-2 nominal-transaksi">{{ $penambahan }}</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-money-bill-transfer text-warning avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Pengajuan Keringanan Hari ini</span>
        <h3 class="card-title color-black mb-2 nominal-transaksi">{{ $keringanan }}</h3>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <i class="fa-solid fa-school text-dark avatar-icon"></i>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Transaksi Pengeluaran Hari ini</span>
        <h3 class="card-title color-black mb-2 nominal-transaksi">{{ $pengeluaran }}</h3>
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
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pembayaran-spp" aria-controls="navs-pills-pembayaran-spp" aria-selected="true">Biaya Penunjang Pendidikan</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-siswa" aria-controls="navs-pills-tabungan-siswa" aria-selected="false">Tabungan Siswa</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tabungan-guru" aria-controls="navs-pills-tabungan-guru" aria-selected="false">Tabungan Guru</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pengajuan-penambahan" aria-controls="navs-pills-pengajuan-penambahan" aria-selected="false">Pengajuan Penambahan</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pengajuan-keringanan" aria-controls="navs-pills-pengajuan-keringanan" aria-selected="false">Pengajuan Keringanan</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pengeluaran" aria-controls="navs-pills-pengeluaran" aria-selected="false">Pengeluaran</button>
          </li>
        </ul>
      </div>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-pembayaran-spp" role="tabpanel">
          @if(count($data_transaksi_spp) != 0)
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi-spp">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Teller</th>
                  <th>NIS/NIP</th>
                  <th>Nama Siswa</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data_transaksi_spp as $dts)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($dts->tanggal)->translatedFormat('d F Y') }}</p>
                  </td>
                  <td class="text-medium color-neutral-100">{{ $dts->Admin->nama }}</td>
                  <td class="text-medium color-neutral-100">{{ $dts->nama_transaksi }}</td>
                  <td>
                    <p class="text-medium text-black">{{ $dts->Anggota->nama }} ‘kelas {{ $dts->Anggota->Kelas->nama }} {{ $dts->Anggota->Jurusan->nama }} {{ $dts->Anggota->nomor_kelas }}’</p>
                  </td>
                  <td>
                    <p class="text-bold text-black nominal-transaksi">{{ $dts->jumlah }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/{{$dts->Anggota->id_anggota}}" class="table__link-detail d-flex align-items-center gap-2">
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
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Biaya Penunjang Pendidikan Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data pembayaran terlebih dulu untuk melihat data Biaya Penunjang Pendidikan.</p>
          </div>
          @endif
        </div>
        <div class="tab-pane fade" id="navs-pills-tabungan-siswa" role="tabpanel">
          @if(count($data_tabungan_siswa) != 0)
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi-tabungan-siswa">
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
              <tbody>
                @foreach($data_tabungan_siswa as $dts)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($dts->tanggal)->translatedFormat('d F Y') }}</p>
                  </td>
                  <td class="text-medium color-neutral-100">{{ $dts->Admin->nama }}</td>
                  <td class="text-medium color-neutral-100">{{ $dts->Anggota->nis }}</td>
                  <td>
                    <p class="text-medium text-black">{{ $dts->Anggota->nama }} ‘kelas {{ $dts->Anggota->Kelas->nama }} {{ $dts->Anggota->Jurusan->nama }} {{ $dts->Anggota->nomor_kelas }}’</p>
                  </td>
                  <td>
                    <p class="text-bold text-black nominal-transaksi">{{ $dts->jumlah }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/{{$dts->Anggota->id_anggota}}" class="table__link-detail d-flex align-items-center gap-2">
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
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Tabungan Siswa Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan siswa.</p>
          </div>
          @endif
        </div>
        <div class="tab-pane fade" id="navs-pills-tabungan-guru" role="tabpanel">
          @if(count($data_tabungan_guru) != 0)
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi-tabungan-guru">
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
              <tbody>
                @foreach($data_tabungan_guru as $dtg)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($dtg->tanggal)->translatedFormat('d F Y') }}</p>
                  </td>
                  <td class="text-medium color-neutral-100">{{ $dtg->Admin->nama }}</td>
                  <td class="text-medium color-neutral-100">{{ $dtg->Anggota->nip }}</td>
                  <td>
                    <p class="text-medium text-black">{{ $dtg->Anggota->nama }} '{{ $dtg->Anggota->Jabatan != null ? $dtg->Anggota->Jabatan->nama : 'Guru' }}'</p>
                  </td>
                  <td>
                    <p class="text-bold text-black nominal-transaksi">{{ $dtg->jumlah }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/history-transaksi-siswa/detail/{{$dtg->Anggota->id_anggota}}" class="table__link-detail d-flex align-items-center gap-2">
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
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Tabungan Guru Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data tabungan terlebih dulu untuk melihat data tabungan guru.</p>
          </div>
          @endif
        </div>
        <div class="tab-pane fade" id="navs-pills-pengajuan-penambahan" role="tabpanel">
          @if(count($data_penambahan) != 0)
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi-pengajuan-penambahan">
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
                @foreach($data_penambahan as $dp)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($dp->tanggal)->translatedFormat('d F Y') }}</p>
                  </td>
                  <td class="text-medium color-neutral-100">{{ $dp->Anggota->nis }}</td>
                  <td>
                    <p class="text-medium text-black">{{ $dp->Anggota->nama }} ‘kelas {{ $dp->Anggota->Kelas->nama }} {{ $dp->Anggota->Jurusan->nama }} {{ $dp->Anggota->nomor_kelas }}’</p>
                  </td>
                  <td>
                    <p class="text-bold text-black nominal-transaksi">{{ $dp->jumlah }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/pengajuan-keringanan/{{$dp->Anggota->id_anggota}}" class="table__link-detail d-flex align-items-center gap-2">
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
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Pengajuan Penambahan Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data pengajuan terlebih dulu untuk melihat data pengajuan Penambahan.</p>
          </div>
          @endif
        </div>
        <div class="tab-pane fade" id="navs-pills-pengajuan-keringanan" role="tabpanel">
          @if(count($data_keringanan) != 0)
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi-pengajuan-keringanan">
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
                @foreach($data_keringanan as $dk)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($dk->tanggal)->translatedFormat('d F Y') }}</p>
                  </td>
                  <td class="text-medium color-neutral-100">{{ $dk->Anggota->nis }}</td>
                  <td>
                    <p class="text-medium text-black">{{ $dk->Anggota->nama }} ‘kelas {{ $dk->Anggota->Kelas->nama }} {{ $dk->Anggota->Jurusan->nama }} {{ $dk->Anggota->nomor_kelas }}’</p>
                  </td>
                  <td>
                    <p class="text-bold text-black nominal-transaksi">{{ $dk->jumlah }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/pengajuan-keringanan/{{$dk->Anggota->id_anggota}}" class="table__link-detail d-flex align-items-center gap-2">
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
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Pengajuan Keringanan Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data pengajuan terlebih dulu untuk melihat data pengajuan Keringanan.</p>
          </div>
          @endif
        </div>
        <div class="tab-pane fade" id="navs-pills-pengeluaran" role="tabpanel">
          @if(count($data_pengeluaran) != 0)
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="riwayat-transaksi-pengeluaran">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Teller</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data_pengeluaran as $dp)
                <tr>
                  <td>
                    <p>{{ \Carbon\Carbon::parse($dp->tanggal)->translatedFormat('d F Y') }}</p>
                  </td>
                  <td>
                    <p class="text-medium text-black">{{ $dp->Admin->nama }}</p>
                  </td>
                  <td>
                    <p class="text-medium text-black">{{ $dp->nama_transaksi }}</p>
                  </td>
                  <td>
                    <p class="text-bold text-black nominal-transaksi">{{ $dp->jumlah }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center justify-content-start gap-3">
                      <a href="/transaksi/pengeluaran" class="table__link-detail d-flex align-items-center gap-2">
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
          <div class="d-flex flex-column align-items-center justify-content-center text-center empty-state">
            <img src="{{asset('assets/img/sikas/empty-illustration.png')}}" alt="">
            <h4 class="text-bold color-neutral-100">Data Pengeluaran Dana Kosong</h4>
            <p class="color-neutral-80">Silahkan tambahkan data pengeluaran terlebih dulu untuk melihat data pengeluaran dana.</p>
          </div>
          @endif
        </div>
      </div>
    </div>
</div>
@endsection