@extends('sikas/layout/layout')

@section('title', 'Dashboard - Sikas')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/sikas-dashboard.css')}}">
@endsection

@section('content')
  <div class="container">
    <div class="card">
      <h4 class="card-header">Transaksi Terakhir</h4>
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <caption class="ms-4">Daftar of Transaksi Terakhir</caption>
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>NISN/NIP</th>
              <th>Nama</th>
              <th>Nominal</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <p>02-January-2023</p>
              </td>
              <td class="text-medium text-primary">1010292938384747</td>
              <td>
                <p class="text-medium text-black">Faisal Adi Prayugo</p>
              </td>
              <td>
                <p class="text-bold text-black">Rp 1.000.000,00</p>
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <p>02-January-2023</p>
              </td>
              <td class="text-medium text-primary">1010292938384747</td>
              <td>
                <p class="text-medium text-black">Bayu Wicaksono</p>
              </td>
              <td>
                <p class="text-bold text-black">Rp 1.000.000,00</p>
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <p>02-January-2023</p>
              </td>
              <td class="text-medium text-primary">1010292938384747</td>
              <td>
                <p class="text-medium text-black">Faiz Pulungan</p>
              </td>
              <td>
                <p class="text-bold text-black">Rp 1.000.000,00</p>
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <p>02-January-2023</p>
              </td>
              <td class="text-medium text-primary">1010292938384747</td>
              <td>
                <p class="text-medium text-black">Ibnu Suhaemy</p>
              </td>
              <td>
                <p class="text-bold text-black">Rp 1.000.000,00</p>
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <a href="#" class="btn btn-primary d-block">Lihat Semua History Transaksi</a>
      </div>
    </div>
  </div>
@endsection
