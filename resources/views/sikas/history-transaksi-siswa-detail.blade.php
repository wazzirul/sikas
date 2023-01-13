@extends('sikas/layout/layout')

@section('title', 'History Pembayaran - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/history-transaksi-siswa-detail.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi / Pembayaran /</span> History Pembayaran
</p>
<div class="card card--history-transaksi-siswa">
  <div class="card-body">
    <div class="detail-siswa-history">
      <div class="d-flex flex-row justify-content-between align-items-center gap-3">
        <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
          <i class="fa-regular fa-user detail-siswa__icon"></i>
          <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
          <div class="d-flex flex-column gap-1">
            <h5 class="text-bold color-neutral-100">{{ $anggota->nama }}</h5>
            <p class="nomor-siswa color-neutral-80">{{ $anggota->nis ?? $anggota->nip }}</p>
          </div>
        </div>
        <div class="d-flex flex-column gap-1">
          @if($anggota->tipe_anggota == 2)
          <p class="color-neutral-80">Kelas</p>
          <h5 class="text-bold color-neutral-100">{{ $anggota->Kelas->nama }} {{ $anggota->Jurusan->nama }} {{ $anggota->nomor_kelas }}</h5>
          @else
          <p class="color-neutral-80">Jabatan</p>
          <h5 class="text-bold color-neutral-100">{{ $anggota->Jabatan->jabatan ?? 'Guru' }}</h5>
          @endif
        </div>
      </div>
      <div class="d-flex flex-row justify-content-between align-items-center gap-3 mt-4 detail-siswa-history__subs">
        @if($anggota->tipe_anggota == 2)
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Sisa Tanggungan</p>
          <h5 class="text-bold text-primary sisa-tanggungan">{{ $anggota->KeuanganAnggota->tagihan }}</h5>
        </div>
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Total Keringanan</p>
          <h5 class="text-bold text-info total-keringanan">{{ $total_keringanan }}</h5>
        </div>
        @endif
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Total Tabungan</p>
          <h5 class="text-bold text-success total-tabungan">{{ $anggota->KeuanganAnggota->tabungan }}</h5>
        </div>
      </div>
    </div>
    <div class="border-line"></div>
    <div class="history-pembayaran-filter d-flex flex-row justify-content-between align-items-end">
      <div class="tahun-ajaran">
        <label for="tahunAjaran" class="form-label">Cari Berdasarkan Tahun Ajaran</label>
        <div class="tahun-ajaran-input">
          <input type="number" class="form-control" id="tahunAjaran" placeholder="2023">
          <i class="fa-regular fa-calendar input-icon color-neutral-50"></i>
        </div>
      </div>
      <a href="#" class="btn btn-outline-primary">
        Export
        <i class="fa-solid fa-print text-primary"></i>
      </a>
    </div>
    <div class="table-responsive text-nowrap mt-4">
      <table class="table table-striped" id="history-pembayaran">
        <caption class="ms-4">Daftar History Pembayaran</caption>
        <thead>
          <tr>
            <th class="text-bold">Tanggal</th>
            <th class="text-bold">Jenis Pembayaran</th>
            <th class="text-bold">Keterangan</th>
            <th class="text-bold">Jumlah Pembayaran</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($transaksi as $t)
          <tr>
            <td class="color-neutral-100">{{ \Carbon\Carbon::parse($t->tanggal)->format('F, d Y') }}</td>
            <td class="color-neutral-100">{{ $t->tipe_transaksi == 1 ? 'Uang SPP' : 'Tabungan' }}</td>
            @if($t->tipe_transaksi == 1)
            <td class="color-neutral-100">Pembayaran</td>
            @else
            <td class="color-neutral-100">{{ $t->tipe_transaksi == 2 ? 'Setor' : 'Tarik' }}</td>
            @endif
            <td class="color-neutral-100 nominal-transaksi">{{ $t->jumlah }}</td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-primary d-flex align-items-center gap-2" onClick="changeTransaksi({{ $t->id_transaksi }}, {{ $t->tipe_transaksi }}, {{ $t->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-primary d-flex align-items-center gap-2" onClick="changeTransaksi({{ $t->id_transaksi }}, {{ $t->tipe_transaksi }}, {{ $t->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  Hapus <i class="fa-regular fa-trash-can"></i>
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
          <input type="hidden" id="id_anggota" />
          <input type="hidden" id="tipe_transaksi" />
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
          <h4 class="color-black text-bold text-center">Hapus Transaksi Pembayaran</h4>
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
<div class="modal modal--transaksi fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Uang SPP berhasil diubah menjadi Rp. 700.000</p>
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
          <p class="color-neutral-80">Uang SPP berhasil dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
