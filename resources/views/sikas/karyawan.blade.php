@extends('sikas/layout/layout')

@section('title', 'Karyawan - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/karyawan.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-karyawan.css')}}">
@endsection

@section('current-pages-title')
  Karyawan
@endsection

@section('content')
<div class="card card--karyawan">
  <div class="karyawan-wrapper">
    <h4 class="text-bold color-black mb-4">Data Karyawan</h4>    
    <div class="d-flex align-items-center justify-content-end gap-4 mb-5">
      <form action="#" class="form-upload-karyawan">
        <input type="file" name="upload" id="karyawan-upload-file" class="d-none">
        <label for="karyawan-upload-file" class="btn btn-outline-primary d-flex gap-2 align-items-center">
            Upload Karyawan
            <i class="fa-solid fa-arrow-up-from-bracket"></i>
        </label>
      </form>
      <button class="d-flex btn btn-primary gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#modalAddData">
        Tambah Karyawan
        <i class="fa-solid fa-plus"></i>
      </button>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-karyawan">
        <thead>
          <tr>
            <th>NIP</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">172410103026</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Adi prahita</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Guru</p>
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
              <p class="text-medium color-neutral-100">172410103026</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Arsy devano</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Kepala Sekolah</p>
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
              <p class="text-medium color-neutral-100">172410103026</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Bayu adi</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Guru</p>
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
<div class="modal modal--karyawan fade" id="modalAddData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Tambah Karyawan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="#">
          <div class="mb-3">
            <label for="nama_karyawan" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama_karyawan" placeholder="Nama Karyawan..." value="">
          </div>
          <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip" placeholder="NIP..." value="">
          </div>
          <div class="mb-3">
            <label for="jabatan" class="form-label text-bold color-black">Jabatan</label>
            <select id="jabatan" class="form-select">
              <option value="kepala-sekolah">Kepala Sekolah</option>
              <option value="Guru">Guru</option>
              <option value="Admin">Admin</option>
              <option value="Security">Security</option>
            </select>
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
<div class="modal modal--karyawan fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Karyawan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="#">
          <div class="mb-3">
            <label for="nama_karyawan" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama_karyawan" placeholder="Nama Karyawan..." value="">
          </div>
          <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip" placeholder="NIP..." value="">
          </div>
          <div class="mb-3">
            <label for="jabatan" class="form-label text-bold color-black">Jabatan</label>
            <select id="jabatan" class="form-select">
              <option value="kepala-sekolah">Kepala Sekolah</option>
              <option value="Guru">Guru</option>
              <option value="Admin">Admin</option>
              <option value="Security">Security</option>
            </select>
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
<div class="modal modal--karyawan fade" id="modalDeleteData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Data Karyawan</h4>
        </div>
        <form action="#" class="mt-3">
          <p class="color-neutral-100 text-center">Apakah anda yakin ingin menghapus data Karyawan ‘ <span class="text-bold">Adi Prahita</span> ‘</p>
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
<div class="modal modal--karyawan fade" id="modalAddSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Data Karyawan</h4>
          <p class="color-neutral-80">Data Karyawan Berhasil Ditambahkan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--karyawan fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Data Karyawan Berhasil Diubah</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--karyawan fade" id="modalDeleteSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Data</h4>
          <p class="color-neutral-80">Data Karyawan Berhasil Dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
