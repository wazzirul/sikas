@extends('sikas/layout/blankLayout')
@extends('layouts/blankLayout')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection


@section('content')
<!-- Error -->
<div class="container-xxl container-p-y">
  <div class="misc-wrapper">
    <h2 class="mb-2 mx-2">Halaman Tidak Ditemukan :(</h2>
    <p class="mb-4 mx-2">Oops! 😖 URL yang diminta tidak ditemukan.</p>
    <a href="{{url('/')}}" class="btn btn-primary">Kembali ke Dashboard</a>
    <div class="mt-5">
      <img src="{{asset('assets/img/illustrations/page-misc-error-light.png')}}" alt="page-misc-error-light" width="500" class="img-fluid">
    </div>
  </div>
</div>
<!-- /Error -->
@endsection
