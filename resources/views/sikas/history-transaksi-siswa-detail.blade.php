@extends('sikas/layout/layout')

@section('title', 'History Pembayaran - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/printjs/print.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/printjs/print.min.js')}}"></script>
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
  <span class="text-muted fw-light">Transaksi / </span> Riwayat Transaksi Siswa
</p>
<div class="card card--history-transaksi-siswa">
  <div class="card-body">
    <div class="detail-siswa-history">
      <div class="d-flex flex-row justify-content-between align-items-center gap-3">
        <div class="d-flex flex-row gap-3 align-items-center detail-siswa__item-nama color-neutral-100">
          <i class="fa-regular fa-user detail-siswa__icon"></i>
          <input type="hidden" id="ctoken" value="{{ csrf_token() }}">
          <div class="d-flex flex-column gap-1">
            <h5 class="text-bold color-neutral-100 detail-siswa-history__nama" id="detail-siswa-history__nama">{{ $anggota->nama }}</h5>
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
          <p class="color-neutral-80">Sisa Partisipasi BPP</p>
          <h5 class="text-bold text-primary sisa-tanggungan">{{ $anggota->KeuanganAnggota->tagihan }}</h5>
        </div>
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Total Pengajuan Penambahan</p>
          <h5 class="text-bold text-info total-penambahan">{{ $total_penambahan }}</h5>
        </div>
        <div class="d-flex flex-column gap-1">
          <p class="color-neutral-80">Total Keringanan</p>
          <h5 class="text-bold text-warning total-keringanan">{{ $total_keringanan }}</h5>
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
      <button class="btn btn-outline-primary button-cetak-laporan" id="button-cetak-laporan">
        Export
        <i class="fa-solid fa-print text-primary"></i>
      </button>
    </div>
    <div class="table-responsive text-nowrap mt-4">
      <table class="table table-striped" id="history-pembayaran">
        <caption class="ms-4">Daftar Riwayat Transaksi</caption>
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
            <td class="color-neutral-100">{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('F, d Y') }}</td>
            <td class="color-neutral-100">{{ $t->tipe_transaksi == 1 ? 'Transaksi BPP' : 'Tabungan' }}</td>
            @if($t->tipe_transaksi == 1)
            <td class="color-neutral-100">Pembayaran</td>
            @else
            <td class="color-neutral-100">{{ $t->tipe_transaksi == 2 ? 'Setor' : 'Tarik' }}</td>
            @endif
            <td class="color-neutral-100 nominal-transaksi">{{ $t->jumlah }}</td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail text-info d-flex align-items-center gap-2" onClick="changeTransaksi({{ $t->id_transaksi }}, {{ $t->tipe_transaksi }}, {{ $t->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalEditData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-danger d-flex align-items-center gap-2" onClick="changeTransaksi({{ $t->id_transaksi }}, {{ $t->tipe_transaksi }}, {{ $t->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalDeleteData">
                  Hapus <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
          @foreach($keringanan as $k)
          <tr>
            <td class="color-neutral-100">{{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('F, d Y') }}</td>
            <td class="color-neutral-100">Transaksi BPP</td>
            <td class="color-neutral-100">Pengajuan Keringanan</td>
            <td class="color-neutral-100 nominal-transaksi">{{ $k->jumlah }}</td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#!" class="table__link-detail d-flex align-items-center gap-2 detail-pengajuan" onClick="detailKeringanan({{ $k->jumlah }}, '{{ $k->file }}')" data-file="" data-jumlah="200000" data-bs-toggle="modal" data-bs-target="#modalPengajuanKeringananDetail">
                  Lihat Detail <i class="fa-solid fa-eye"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-info d-flex align-items-center gap-2" onClick="changeTransaksi({{ $k->id_pengajuan_keringanan }}, 6, {{ $k->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalEditPengajuanKeringananData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-danger d-flex align-items-center gap-2" onClick="changeTransaksi({{ $k->id_pengajuan_keringanan }}, 6, {{ $k->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalDeletePengajuanKeringananData">
                  Hapus <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
          @foreach($penambahan as $p)
          <tr>
            <td class="color-neutral-100">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('F, d Y') }}</td>
            <td class="color-neutral-100">Transaksi BPP</td>
            <td class="color-neutral-100">Pengajuan Penambahan</td>
            <td class="color-neutral-100 nominal-transaksi">{{ $p->jumlah }}</td>
            <td>
              <div class="d-flex align-items-center justify-content-cen gap-3">
                <a href="#!" class="table__link-detail d-flex align-items-center gap-2 detail-pengajuan" onClick="detailPenambahan({{ $p->jumlah }}, '{{ $p->file }}')" data-file="" data-jumlah="200000" data-bs-toggle="modal" data-bs-target="#modalPengajuanPenambahanDetail">
                  Lihat Detail <i class="fa-solid fa-eye"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-info d-flex align-items-center gap-2" onClick="changeTransaksi({{ $p->id_pengajuan_penambahan }}, 7, {{ $p->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalEditPengajuanPenambahanData">
                  Edit <i class="fa-solid fa-pen"></i>
                </a>
                <div class="table-link-border"></div>
                <a href="#" class="table__link-detail text-danger d-flex align-items-center gap-2" onClick="changeTransaksi({{ $p->id_pengajuan_penambahan }}, 7, {{ $p->id_anggota }})" data-bs-toggle="modal" data-bs-target="#modalDeletePengajuanPenambahanData">
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
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalEditData" tabindex="-1" aria-hidden="true">
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
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalEditPengajuanPenambahanData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Edit Transaksi Pengajuan Penambahan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <div class="mt-5">
          <form id="form-update-pengajuan-penambahan" action="/query/updatePengajuanPenambahan" class="pengajuan-keringanan-form" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id_pengajuan_penambahan" id="id_pengajuan_penambahan"  />
            <div class="pengajuan-keringanan-form__input-wrapper">
              <div class="pengajuan-keringanan-form__input">
                <label for="upload-surat-pengajuan" class="form-label color-black">Upload Surat Pengajuan <span class="text-secondary text-extra-bold">*Optional</span></label>
                <input class="form-control" type="file" name="file-pengajuan" id="upload-surat-pengajuan" accept="application/pdf">
                <small class="text-bold color-black">Siswa / Siswi Tidak Wajib memberikan surat / file pengajuan berupa pdf</small>
              </div>
              <div class="pengajuan-keringanan-form__item-upload d-none">
                <i class="fa-solid fa-file-pdf text-primary file-icon"></i>
                <p class="color-neutral-100 file-name">-</p>
              </div>
            </div>
            <div class="mt-3">
              <label for="nominalPenambahan" class="form-label text-bold color-black">Nominal Penambahan</label>
              <input type="text" min="0" class="form-control" required id="nominalPenambahan" name="nominalPenambahan" placeholder="0.00">
            </div>
            <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
              <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
              <button type="submit" class="btn btn-primary pengajuan-keringanan-button w-100">Ajukan Penambahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalEditPengajuanKeringananData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Edit Transaksi Pengajuan Keringanan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <div class="mt-5">
        <form id="form-update-pengajuan-keringanan" action="/query/updatePengajuanKeringanan" class="pengajuan-keringanan-form" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="id_pengajuan_keringanan" id="id_pengajuan_keringanan"  />
          <div class="pengajuan-keringanan-form__input-wrapper">
            <div class="pengajuan-keringanan-form__input">
              <label for="upload-surat-pengajuan" class="form-label color-black">Upload Surat Pengajuan <span class="text-danger text-extra-bold">*Required</span></label>
              <input class="form-control" type="file" required name="file-pengajuan" id="upload-surat-pengajuan" autocomplete="off" accept="application/pdf">
              <small class="text-bold color-black">Siswa / Siswi Wajib memberikan surat / file pengajuan berupa pdf</small>
            </div>
            <div class="pengajuan-keringanan-form__item-upload d-none">
              <i class="fa-solid fa-file-pdf text-primary file-icon"></i>
              <p class="color-neutral-100 file-name">-</p>
            </div>
          </div>
          <div class="mt-3">
            <label for="nominalKeringanan" class="form-label text-bold color-black">Nominal Keringanan</label>
            <input type="text" min="0" class="form-control" required id="nominalKeringanan" name="nominalKeringanan" placeholder="0.00">
          </div>
          <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
            <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
            <button class="btn btn-primary pengajuan-keringanan-button w-100">Ajukan Keringanan</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalDeleteData" tabindex="-1" aria-hidden="true">
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
          <p class="color-neutral-80">Transaksi BPP berhasil diubah menjadi Rp. 700.000</p>
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
          <p class="color-neutral-80">Transaksi BPP berhasil dihapus</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<button type="hidden" id="successPengajuanPenambahan" data-bs-toggle="modal" data-bs-target="#modalPengajuanPenambahan"></button>
<div class="modal modal--transaksi fade" id="modalPengajuanPenambahan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengajukan Penambahan</h4>
          <p class="color-neutral-80">Terima kasih telah menambah Biaya Penunjang Pendidikan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--pengajuan-keringanan fade" id="modalPengajuanPenambahanDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Detail Pengajuan Penambahan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <div class="pengajuan-keringanan-detail mt-5">
          <div class="d-flex flex-column mb-5 align-items-center text-center">
            <h4 class="color-black mb-3">Jumlah Penambahan</h4>
            <h5 class="text-bold text-success modal-jumlah-penambahan">-</h5>
          </div>
          <h6 class="text-bold mb-3">Surat Pengajuan</h6>
          <a href="#" download class="d-flex flex-row align-items-center pengajuan-keringanan-form__item-upload gap-3 modal-download-penambahan">
            <i class="fa-solid fa-file-pdf text-primary file-icon"></i>
            <p class="color-neutral-100 modal-file-penambahan">-</p>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<button type="hidden" id="successPengajuanKeringanan" data-bs-toggle="modal" data-bs-target="#modalPengajuanKeringanan"></button>
<div class="modal modal--transaksi fade" id="modalPengajuanKeringanan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Mengajukan Keringanan</h4>
          <p class="color-neutral-80">Lanjutkan untuk melakukan proses pembayaran pada halaman pembayaran</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--pengajuan-keringanan fade" id="modalPengajuanKeringananDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h4 class="color-black text-bold">Detail Pengajuan Keringanan</h4>
          <a href="#" data-bs-dismiss="modal" class="text-danger" aria-label="Close">
            <i class="fa-solid fa-xmark icon"></i>
          </a>
        </div>
        <div class="pengajuan-keringanan-detail mt-5">
          <div class="d-flex flex-column mb-5 align-items-center text-center">
            <h4 class="color-black mb-3">Jumlah Keringanan</h4>
            <h5 class="text-bold text-success modal-jumlah-keringanan">-</h5>
          </div>
          <h6 class="text-bold mb-3">Surat Pengajuan</h6>
          <a href="#" download class="d-flex flex-row align-items-center pengajuan-keringanan-form__item-upload gap-3 modal-download-keringanan">
            <i class="fa-solid fa-file-pdf text-primary file-icon"></i>
            <p class="color-neutral-100 modal-file-keringanan">-</p>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalDeletePengajuanPenambahanData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Transaksi Pengajuan Penambahan</h4>
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
          <button class="btn btn-danger w-100 delete-penambahan-button" data-bs-toggle="modal" data-bs-target="#modalDeletePengajuanPenambahanDataSuccess">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalDeletePengajuanPenambahanDataSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Pengajuan Penambahan Data</h4>
          <p class="color-neutral-80">Pengajuan Penambahan berhasil dihapus.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalDeletePengajuanKeringananData" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center gap-3">
          <h4 class="color-black text-bold text-center">Hapus Transaksi Pengajuan Keringanan</h4>
        </div>
        <div class="d-flex flex-row align-items-stretch gap-3 mt-5">
          <button class="btn btn-outline-primary w-100" data-bs-dismiss="modal" >Batal</button>
          <button class="btn btn-danger w-100 delete-keringanan-button" data-bs-toggle="modal" data-bs-target="#modalDeletePengajuanKeringananDataSuccess">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal--transaksi modal--transaksi-form fade" id="modalDeletePengajuanKeringananDataSuccess" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menghapus Pengajuan Keringanan Data</h4>
          <p class="color-neutral-80">Pengajuan Keringanan berhasil dihapus.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
