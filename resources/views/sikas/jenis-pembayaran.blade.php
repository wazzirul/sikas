@extends('sikas/layout/layout')

@section('title', 'Jenis Transaksi - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/jenis-pembayaran.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-jenis-pembayaran.css')}}">
<style>
  .spinner-overlay {
    display: none;
    z-index: 9999;
    background: rgba(33, 33, 33, .6);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }

  .spinner {
    width: 70px;
    text-align: center;
  }

  .spinner-overlay__inner {
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }

  .spinner__bounce {
    width: 18px;
    height: 18px;
    background-color: #FFFFFF;
    border-radius: 100%;
    display: inline-block;
    animation: bouncedelay 1.4s infinite ease-in-out both;
      animation-delay: 0s;
  }

  .spinner__bounce--1 {
    animation-delay: -0.32s;
  }

  .spinner__bounce--2 {
    animation-delay: -0.16s;
  }

  @keyframes bouncedelay {
    0%, 80%, 100% {
        transform: scale(0);
    } 
    40% {
      transform: scale(1);
    }
  }
</style>
@endsection

@section('current-pages-title')
  Jenis Transaksi
@endsection

@section('content')
<div class="card card--jenis-pembayaran">
  <div class="jenis-pembayaran-wrapper">
    <!-- Spinner -->
    <div class="spinner-overlay" id="animation-overlay">
      <div class="spinner-overlay__inner">
        <div class="spinner">
          <div class="spinner__bounce spinner__bounce--1"></div>
          <div class="spinner__bounce spinner__bounce--2"></div>
          <div class="spinner__bounce spinner__bounce--3"></div>
        </div>
      </div>
    </div>

    <h4 class="text-bold color-black mb-4">Data Jenis Transaksi</h4>       
    <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
      <div class="d-flex align-items-center gap-4">
        <button class="d-flex btn btn-primary gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#modalAddData">
          Tambah Jenis Transaksi
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-jenis-pembayaran" id="data-jenis-pembayaran">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama BPP</th>
            <th>Kelas</th>
            <th>Nominal</th>
            <th>Tipe Pembayaran</th>
            <th>Status</th>
            <th>Angkatan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($tagihan as $t)
          <tr class="{{ $t->status == 1 ? 'active' : 'nonactive' }}">
            <td>
              <p class="text-medium color-neutral-100">{{ $t->id_tagihan}}</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $t->nama }}</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $t->Kelas->nama }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100 nominal-pembayaran">{{ $t->jumlah }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $t->flow_tagihan == 1 ? 'Angsuran' : 'Bulanan' }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $t->status == 1 ? 'Tagihan Aktif' : 'Tagihan Tidak Aktif' }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $t->angkatan ?? '-' }}</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-info" onClick="changeTagihan({{$t->id_tagihan}})" data-bs-toggle="modal" data-bs-target="#{{ $t->tipe_tagihan == 1 ? 'modalEditData' : 'modalEditTransaksiLainData' }}">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                @if($t->tipe_tagihan != 1)
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-danger" onClick="changeTagihan({{$t->id_tagihan}})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  Delete <i class="fa-solid fa-trash-can"></i>
                </a>
                @endif
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
<div class="modal modal--jenis-pembayaran fade" id="modalAddData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Tambah Jenis Transaksi</h4>
          <input type="hidden" id="id_tagihan"/>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="/jenis-transaksi/post" method="POST">
          {{ csrf_field() }}
          <div class="mb-3">
            <label for="nama" class="form-label">Nama / Jenis Transaksi</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama / Jenis Transaksi..." required>
          </div>
          <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select id="id_kelas" name="id_kelas" class="form-select" required>
              @foreach($kelas as $k)
                <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="status_siswa" class="form-label">Status Siswa</label>
            <select id="status_siswa" name="status_siswa" class="form-select status-siswa" required>
                <option value="aktif">Aktif</option>
                <option value="alumni">Alumni</option>
            </select>
          </div>
          <div class="mb-3 div-angkatan d-none">
            <label for="angkatan" class="form-label d-block">Angkatan</label>
            <select class="js-angkatan-multiple" name="angkatan[]" multiple="multiple">
              @foreach($all_angkatan as $aa)
              <option value="{{ $aa }}">{{ $aa }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="jumlah" class="form-label">Nominal</label>
            <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Nominal..." required>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal modal--jenis-pembayaran fade" id="modalEditTransaksiLainData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Jenis Transaksi</h4>
          <input type="hidden" id="id_tagihan"/>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
          <div class="mb-3">
            <label for="update_lain_nama" class="form-label">Nama / Jenis Transaksi</label>
            <input type="text" class="form-control" name="update_lain_nama" id="update_lain_nama" placeholder="Nama / Jenis Transaksi..." required>
          </div>
          <div class="mb-3">
            <label for="update_lain_id_kelas" class="form-label">Kelas</label>
            <select id="update_lain_id_kelas" name="update_lain_id_kelas" class="form-select" required>
              @foreach($kelas as $k)
                <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="update_lain_status_siswa" class="form-label">Status Siswa</label>
            <select id="update_lain_status_siswa" name="update_lain_status_siswa" class="form-select status-siswa" required>
                <option value="aktif">Aktif</option>
                <option value="alumni">Alumni</option>
            </select>
          </div>
          <div class="mb-3 div-angkatan d-none">
            <label for="update_lain_angkatan" class="form-label d-block">Angkatan</label>
            <select class="js-angkatan-multiple" name="update_lain_angkatan" id="update_lain_angkatan">
              @foreach($all_angkatan as $aa)
              <option value="{{ $aa }}">{{ $aa }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="update_lain_jumlah" class="form-label">Nominal</label>
            <input type="text" class="form-control" name="update_lain_jumlah" id="update_lain_jumlah" placeholder="Nominal..." required>
          </div>
          <div class="mb-3">
            <label for="update_lain_status_transaksi" class="form-label">Status Transaksi</label>
            <select id="update_lain_status_transaksi" name="update_lain_status_transaksi" class="form-select" required>
                <option value="1">Aktif</option>
                <option value="2">Nonaktif</option>
            </select>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button type="submit" class="btn btn-primary w-100 update-lain-tagihan-button">Simpan</button>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--jenis-pembayaran fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Jenis Transaksi</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
          <div class="mb-3">
            <label for="update_nama" class="form-label">Nama / Jenis Transaksi</label>
            <input type="text" class="form-control" id="update_nama" placeholder="Nama / Jenis Transaksi..." required>
          </div>
          <div class="mb-3">
            <label for="update_id_kelas" class="form-label">Kelas</label>
            <select id="update_id_kelas" class="form-select disabled" disabled>
              @foreach($kelas as $k)
                <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="flow_pembayaran" class="form-label">Flow Pembayaran</label>
            <select id="flow_pembayaran" class="form-select disabled" disabled>
                <option value="Angsuran">Angsuran</option>
                <option value="Bulanan">Bulanan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="update_jumlah" class="form-label">Nominal</label>
            <input type="text" class="form-control" id="update_jumlah" placeholder="Nominal..." required>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button type="button" class="btn btn-primary w-100 update-tagihan-button">Simpan</button>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--jenis-pembayaran fade" id="modalDeleteData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Data Jenis Transaksi</h4>
        </div>
        <div class="mt-3">
          <p class="color-neutral-100 text-center">Apakah anda yakin ingin menghapus data Jenis Transaksi ‘ <span class="text-bold nama-delete-modal">-</span> ‘</p>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-danger w-100 delete-tagihan-button" data-bs-toggle="modal" data-bs-target="#modalDeleteSuccess">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--jenis-pembayaran fade" id="modalAddSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Data Jenis Transaksi</h4>
          <p class="color-neutral-80">Data Jenis Transaksi Berhasil Ditambahkan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<button type="hidden" class="d-none" id="button_edit_success" data-bs-toggle="modal" data-bs-target="#modalEditSuccess"></button>
<div class="modal modal--jenis-pembayaran fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Data Jenis Transaksi Berhasil Diubah</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--jenis-pembayaran fade" id="modalDeleteSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Data</h4>
          <p class="color-neutral-80">Data Jenis Transaksi Berhasil Dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<button type="hidden" class="d-none" id="button_edit_gagal" data-bs-toggle="modal" data-bs-target="#modalEditGagal"></button>
<div class="modal modal--jenis-pembayaran fade" id="modalEditGagal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-xmark icon-success text-danger"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Error! Anda Gagal Melakukan Update Data.</h4>
          <p class="color-neutral-80">Periksa koneksi anda dan ulangi update data.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
