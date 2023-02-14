@extends('sikas/layout/layout')

@section('title', 'Siswa - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/siswa.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-siswa.css')}}">
@endsection

@section('current-pages-title')
  Siswa
@endsection

@section('content')
<div class="card card--siswa">
  <div class="siswa-wrapper">
    <h4 class="text-bold color-black mb-4">Data Siswa</h4>    
    <div class="siswa-header mb-5">
      <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
      <div class="form-upload-siswa d-flex align-items-end gap-4">
        <div class="mt-3">
          <label for="filter_id_kelas" class="form-label text-bold color-black">Kelas</label>
          <select id="filter_id_kelas" class="form-select">
            <option value="">Semua</option>
            @foreach($kelas as $k)
              <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="mt-3">
          <label for="filter_id_jurusan" class="form-label text-bold color-black">Jurusan</label>
          <select id="filter_id_jurusan" class="form-select">
            <option value="">Semua</option>
            @foreach($jurusan as $j)
              <option value="{{ $j->id_jurusan }}">{{ $j->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="mt-3">
          <label for="filter_nomor_kelas" class="form-label text-bold color-black">Nomor Kelas</label>
          <select id="filter_nomor_kelas" class="form-select">
            <option value="">Semua</option>
            @for($q = 1; $q <= $nomor_kelas + 1; $q++)
              <option value="{{ $q }}">{{ $q }}</option>
            @endfor
          </select>
        </div>
        <div class="mt-3">
          <label for="filter_angkatan_siswa" class="form-label text-bold color-black">Angkatan</label>
          <select id="filter_angkatan_siswa" autocomplete="off" class="form-select">
            <option value="" selected>Aktif</option>
            @foreach($all_angkatan as $aa)
            <option value="{{ $aa }}">{{ $aa }}</option>
            @endforeach
          </select>
        </div>
        <button type="button" class="btn btn-outline-primary cari-siswa-button">Cari Data</button>
      </div>        
      <div class="d-flex align-items-end justify-content-end gap-4">
        <form action="/siswa/import" id="importForm" class="form-upload-siswa" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
          <input type="file" name="file" id="siswa-upload-file" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
          <label for="siswa-upload-file" class="btn btn-outline-primary d-flex gap-2 align-items-center">
              Import Siswa
              <i class="fa-solid fa-arrow-up-from-bracket"></i>
          </label>
        </form>
        <button class="d-flex btn btn-primary gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#modalAddData">
          Tambah Siswa
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="data-siswa">
        <thead>
          <tr>
            <th>Nama</th>
            <th>NIS</th>
            <th>L/P</th>
            <th>Kelas</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tbody-data-siswa">
          @foreach($anggota as $a)
          <tr>
            <td>
              <p class="text-medium color-neutral-100">{{ $a->nama }}</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $a->nis }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $a->jenis_kelamin }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $a->Kelas->nama }} {{ $a->Jurusan->nama }} {{ $a->nomor_kelas }}</p>
            </td>
            <td>
              <p class="text-medium color-neutral-100">{{ $a->alumni == 0 ? 'Siswa Aktif' : ($a->alumni == 1 ? 'Alumni' : 'Keluar') }}</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="/transaksi/history-transaksi-siswa/detail/{{ $a->id_anggota }}" class="table__link-detail d-flex align-items-center gap-2">
                  Detail
                  <i class="fa-solid fa-eye"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-info" onClick="changeAnggota({{ $a->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-danger" onClick="changeAnggota({{ $a->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
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
<div class="modal modal--siswa fade" id="modalAddData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Tambah Siswa</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <form action="/siswa/post" method="POST">
          {{ csrf_field() }}
          <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" placeholder="Nama Siswa..." >
          </div>
          <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="text" class="form-control" name="nis" id="nis" placeholder="NIS..." >
          </div>
          <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="id_kelas" class="form-label text-bold color-black">Kelas</label>
            <select id="id_kelas" name="id_kelas" class="form-select">
              @foreach($kelas as $k)
              <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="id_jurusan" class="form-label text-bold color-black">Jurusan</label>
            <select id="id_jurusan" name="id_jurusan" class="form-select">
              @foreach($jurusan as $j)
              <option value="{{ $j->id_jurusan }}">{{ $j->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="nomor_kelas" class="form-label text-bold color-black">Nomor Kelas</label>
            <input type="number" class="form-control" id="nomor_kelas" name="nomor_kelas" placeholder="Nomor Kelas..." >
          </div>
          <div class="mb-3">
            <label for="status_siswa" class="form-label">Status Siswa</label>
            <select id="status_siswa" name="status_siswa" class="form-select">
              <option value="0">Siswa Aktif</option>
              <option value="1">Alumni</option>
            </select>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button type="button" class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button type="submit" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAddSuccess">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--siswa fade" id="modalEditData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold mb-4">Edit Siswa</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
          <div class="mb-3">
            <label for="update_nama_siswa" class="form-label">Nama Siswa</label>
            <input type="hidden" id="id_anggota"/>
            <input type="text" class="form-control" id="update_nama_siswa" placeholder="Nama Siswa..." >
          </div>
          <div class="mb-3">
            <label for="update_nis" class="form-label">NIS</label>
            <input type="text" class="form-control" id="update_nis" placeholder="NIS..." >
          </div>
          <div class="mb-3">
            <label for="update_jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select id="update_jenis_kelamin" name="update_jenis_kelamin" class="form-select">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="update_id_kelas" class="form-label text-bold color-black">Kelas</label>
            <select id="update_id_kelas" class="form-select">
              @foreach($kelas as $k)
              <option value="{{ $k->id_kelas }}">{{ $k->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="update_id_jurusan" class="form-label text-bold color-black">Jurusan</label>
            <select id="update_id_jurusan" class="form-select">
              @foreach($jurusan as $j)
              <option value="{{ $j->id_jurusan }}">{{ $j->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="update_nomor_kelas" class="form-label text-bold color-black">Nomor Kelas</label>
            <input type="number" class="form-control" id="update_nomor_kelas" placeholder="Nomor Kelas..." >
          </div>
          <div class="mb-3">
            <label for="update_status_siswa" class="form-label">Jenis Kelamin</label>
            <select id="update_status_siswa" name="update_status_siswa" class="form-select">
              <option value="0">Siswa Aktif</option>
              <option value="1">Alumni</option>
              <option value="2">Keluar</option>
            </select>
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary w-100 update-siswa-button" data-bs-toggle="modal" data-bs-target="#modalEditSuccess">Simpan</button>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--siswa fade" id="modalDeleteData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Data Siswa</h4>
        </div>
        <div class="mt-3">
          <p class="color-neutral-100 text-center">Apakah anda yakin ingin menghapus data Siswa ‘ <span class="text-bold nama-delete-modal">-</span> ‘</p>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-danger w-100 delete-siswa-button" data-bs-toggle="modal" data-bs-target="#modalDeleteSuccess">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--siswa fade" id="modalAddSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Data Siswa</h4>
          <p class="color-neutral-80">Data Siswa Berhasil Ditambahkan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--siswa fade" id="modalEditSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengedit Data</h4>
          <p class="color-neutral-80">Data Siswa Berhasil Diubah</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--siswa fade" id="modalDeleteSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Data</h4>
          <p class="color-neutral-80">Data Siswa Berhasil Dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
