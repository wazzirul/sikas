@extends('sikas/layout/layout')

@section('title', 'Jenis Pembayaran - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/jenis-pembayaran.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-jenis-pembayaran.css')}}">
@endsection

@section('current-pages-title')
  Jenis Pembayaran
@endsection

@section('content')
<div class="card card--jenis-pembayaran">
  <div class="jenis-pembayaran-wrapper">
    <h4 class="text-bold color-black mb-4">Data Jenis / Nama Pembayaran</h4>    
    <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
      <div class="d-flex align-items-center gap-4">
        <button class="d-flex btn btn-primary gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#modalAddData">
          Tambah Jenis Pembayaran
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-jenis-pembayaran">
        <thead>
          <tr>
            <th>No</th>
            <th>Jenis Pembayaran</th>
            <th>Kelas</th>
            <th>Nominal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($tagihan as $t)
          <tr>
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
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-info" onClick="changeTagihan({{$t->id_tagihan}})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
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
<div class="modal modal--jenis-pembayaran fade" id="modalAddData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Tambah Jenis Pembayaran</h4>
          <input type="hidden" id="id_tagihan"/>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="/jenis-pembayaran/post" method="POST">
          {{ csrf_field() }}
          <div class="mb-3">
            <label for="nama" class="form-label">Nama / Jenis Pembayaran</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama / Jenis Pembayaran..." required>
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

<!-- Modal -->
<div class="modal modal--jenis-pembayaran fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Jenis Pembayaran</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
          <div class="mb-3">
            <label for="update_nama" class="form-label">Nama / Jenis Pembayaran</label>
            <input type="text" class="form-control" id="update_nama" placeholder="Nama / Jenis Pembayaran..." required>
          </div>
          <div class="mb-3">
            <label for="update_id_kelas" class="form-label">Kelas</label>
            <select id="update_id_kelas" class="form-select" required>
              @foreach($kelas as $k)
                <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="update_jumlah" class="form-label">Nominal</label>
            <input type="text" class="form-control" id="update_jumlah" placeholder="Nominal..." required>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button type="button" class="btn btn-primary w-100 update-tagihan-button" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Simpan</button>
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
          <h4 class="color-black text-bold text-center">Hapus Data Jenis Pembayaran</h4>
        </div>
        <div class="mt-3">
          <p class="color-neutral-100 text-center">Apakah anda yakin ingin menghapus data Jenis Pembayaran ‘ <span class="text-bold nama-delete-modal">-</span> ‘</p>
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
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Data Jenis Pembayaran</h4>
          <p class="color-neutral-80">Data Jenis Pembayaran Berhasil Ditambahkan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--jenis-pembayaran fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Data Jenis Pembayaran Berhasil Diubah</p>
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
          <p class="color-neutral-80">Data Jenis Pembayaran Berhasil Dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
