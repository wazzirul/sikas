<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class Main extends Controller
{
    //
  public function index(){
    return view('sikas.dashboard');
  }
  public function transaksiPembayaran(){
    return view('sikas.transaksi-pembayaran');
  }
  public function PembayaranAkademik(){
    return view('sikas.transaksi-pembayaran-akademik');
  }
  public function historyTransaksiPembayaran(){
    return view('sikas.history-transaksi-pembayaran');
  }
  public function pengajuanKeringananPembayaran(){
    return view('sikas.transaksi-pengajuan-keringanan-akademik');
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
