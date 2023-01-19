@extends('sikas/layout/layout')

@section('title', 'Teller - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/teller.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-teller.css')}}">
@endsection

@section('current-pages-title')
  Teller
@endsection

@section('content')
<div class="card card--teller">
  <div class="teller-wrapper">
    <h4 class="text-bold color-black mb-4">Data Teller</h4>    
    <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
    <button class="d-block mb-5 btn btn-primary btn-tambah-teller" data-bs-toggle="modal" data-bs-target="#modalAddData">
      Tambah Teller
      <i class="fa-solid fa-plus"></i>
    </button>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-teller">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Password</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($teller as $t)
          <tr>
            <td>
              <p class="text-medium color-neutral-100">{{ $t->nama }}</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">{{ $t->username }}</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">******</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-info" onClick="changeTeller({{$t->id_user}})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-danger" onClick="changeTeller({{$t->id_user}})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
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
<div class="modal modal--teller fade" id="modalAddData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Tambah Teller</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="/teller/post" method="POST">
          {{ csrf_field() }}
          <div class="mb-3">
            <label for="nama_teller" class="form-label">Nama Teller</label>
            <input type="text" class="form-control" name="nama_teller" id="nama_teller" placeholder="Nama Teller..." >
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username..." >
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password">Password</label>
            </div>
            <div class="input-group input-group-merge">
              <input type="text" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
              <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
            </div>
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="re_password">Ulangi Password Anda</label>
            </div>
            <div class="input-group input-group-merge">
              <input type="text" id="re_password" class="form-control" name="re_password" placeholder="············" aria-describedby="re_password">
              <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
            </div>
            <p class="color-neutral-80 mt-1 password-alert d-none"><span class="text-danger">Password tidak sama</span>, pastikan kembali bahwa anda memasukkan password yang sama.</p>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button type="submit" class="btn btn-primary w-100 post-teller-button disabled" data-bs-toggle="modal" data-bs-target="#modalAddSuccess">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--teller fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Teller</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
          <div class="mb-3">
            <label for="update_nama_teller" class="form-label">Nama Teller</label>
            <input type="hidden" id="id_user"/>
            <input type="text" class="form-control" id="update_nama_teller" placeholder="Nama Teller..." >
          </div>
          <div class="mb-3">
            <label for="update_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="update_username" placeholder="Username..." >
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="update_password">Password</label>
            </div>
            <div class="input-group input-group-merge">
              <input type="text" id="update_password" class="form-control" placeholder="············" aria-describedby="password">
              <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
            </div>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary w-100 update-teller-button" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Simpan</button>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--teller fade" id="modalDeleteData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Data Teller</h4>
        </div>
        <div action="#" class="mt-3">
          <p class="color-neutral-100 text-center">Apakah anda yakin ingin menghapus data teller ‘ <span class="text-bold nama-delete-modal">-</span> ‘</p>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-danger w-100 delete-teller-button" data-bs-toggle="modal" data-bs-target="#modalDeleteSuccess">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--teller fade" id="modalAddSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Data Teller</h4>
          <p class="color-neutral-80">Data Teller Berhasil Ditambahkan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--teller fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Data Teller Berhasil Diubah</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--teller fade" id="modalDeleteSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Data</h4>
          <p class="color-neutral-80">Data Teller Berhasil Dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
