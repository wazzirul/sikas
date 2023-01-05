<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Anggota;

class Main extends Controller
{
    //
  public function index(){
    return view('sikas.dashboard');
  }
  

  //Pemasukan dan Pengeluaran
  public function transaksiPemasukan(){
    return view('sikas.transaksi-pemasukan');
  }
  public function transaksiPengeluaran(){
    return view('sikas.transaksi-pengeluaran');
  }

  //Login
  public function login(){
    if(Session::has('authenticated')) return redirect('/');
    return view('sikas.login');
  }
  //Register
  public function register(){
    return view('sikas.register');
  }
}
