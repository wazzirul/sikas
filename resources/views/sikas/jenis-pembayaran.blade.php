@extends('sikas/layout/layout')

@section('title', 'Jenis Pembayaran - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/datatable-tables.js')}}"></script>
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
            <th>Angkatan Tahun</th>
            <th>Nominal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">1</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">SPP</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">2020</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 1.200.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-primary" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-primary" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  Hapus <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">2</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">BPP</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">2021</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 1.500.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-primary" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-primary" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  Hapus <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">3</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">TPP</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">2022</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 2.000.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-primary" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-primary" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  Hapus <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
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
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="#">
          <div class="mb-3">
            <label for="jenis_pembayaran" class="form-label">Nama / Jenis Pembayaran</label>
            <input type="text" class="form-control" id="jenis_pembayaran" placeholder="Nama / Jenis Pembayaran..." value="">
          </div>
          <div class="mb-3">
            <label for="angkatan_tahun" class="form-label">Angkatan Tahun</label>
            <input type="text" class="form-control" id="angkatan_tahun" placeholder="Angkatan Tahun..." value="">
          </div>
          <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="text" class="form-control" id="nominal" placeholder="Nominal..." value="">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAddSuccess">Simpan</button>
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
        <form action="#">
          <div class="mb-3">
            <label for="jenis_pembayaran" class="form-label">Nama / Jenis Pembayaran</label>
            <input type="text" class="form-control" id="jenis_pembayaran" placeholder="Nama / Jenis Pembayaran..." value="">
          </div>
          <div class="mb-3">
            <label for="angkatan_tahun" class="form-label">Angkatan Tahun</label>
            <input type="text" class="form-control" id="angkatan_tahun" placeholder="Angkatan Tahun..." value="">
          </div>
          <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="text" class="form-control" id="nominal" placeholder="Nominal..." value="">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Simpan</button>
          </div>
        </form>
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
        <form action="#" class="mt-3">
          <p class="color-neutral-100 text-center">Apakah anda yakin ingin menghapus data Jenis Pembayaran ‘ <span class="text-bold">SPP</span> ‘</p>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modalDeleteSuccess">Delete</button>
          </div>
        </form>
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
