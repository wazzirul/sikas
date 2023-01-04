@extends('sikas/layout/layout')

@section('title', 'Transaksi Pemasukan - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dataTables/datatables.min.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dataTables/datatables.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages/pemasukan-pengeluaran.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-pemasukan-pengeluaran.css')}}">
@endsection

@section('current-pages-title')
  Transaksi
@endsection

@section('content')
<p class="fw-bold mb-5">
  <span class="text-muted fw-light">Transaksi /</span> Pemasukan
</p>
<div class="card card--pemasukan-pengeluaran">
  <div class="pemasukan-pengeluaran__form">
    <h4 class="text-bold color-black mb-4">Pemasukan</h4>
    <form action="#" class="pengajuan-pemasukan-form">
      <div class="mt-3">
        <label for="nominalPemasukan" class="form-label text-bold color-black">Nominal Pemasukan</label>
        <input type="number" min="0" class="form-control" id="nominalPemasukan" placeholder="0.00">
      </div>
      <div class="mt-3">
        <label for="keterangan" class="form-label text-bold color-black">Keterangan</label>
        <textarea class="form-control" id="keterangan" rows="6" placeholder="Masukan keterangan pemasukan"></textarea>
      </div>
      <button class="btn btn-primary pengajuan-pemasukan-button mt-5" data-bs-toggle="modal" data-bs-target="#modalPengajuanPemasukan">Setor Pemasukan</button>
    </form>
  </div>
  <div class="border-line"></div>
  <div class="riwayat-pemasukan">
    <h4 class="text-bold color-black mb-4">Riwayat Pemasukan</h4>    
    <div class="table-responsive text-nowrap">
      <table class="table table-striped" id="riwayat-pemasukan">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Nominal Pemasukan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-medium color-neutral-100">January, 02 2023</p>
            </td>
            <td class="text-medium">
              <p class="text-medium color-neutral-100">Dana bos</p>              
            </td>
            <td>
              <p class="text-medium color-neutral-100">Rp. 100.000</p>
            </td>
            <td>
              <div class="d-flex align-items-center justify-content-end gap-3">
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="#" class="table__link-detail color-neutral-100">
                  <i class="fa-regular fa-trash-can"></i>
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
<div class="modal modal--transaksi fade" id="modalPengajuanPemasukan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex flex-column justify-content-center align-items-center text-center">
          <i class="fa-solid fa-circle-check icon-success text-success"></i>
          <h4 class="color-neutral-100 mt-3 my-2">Selamat! Anda Berhasil Menambahkan Pemasukan</h4>
          <p class="color-neutral-80">Anda bisa melihat pemasukan yang baru saja anda tambahkan pada riwayat pemasukan.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
