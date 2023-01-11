<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
  public function index(){
    return view('sikas.laporan');
  }
  public function penggunaanDana(){
    return view('sikas.laporan-penggunaan-dana');
  }  
  public function pemasukanSumberLain(){
    return view('sikas.laporan-pemasukan-sumber-lain');
  }   
  public function pengajuanKeringanan(){
    return view('sikas.laporan-pengajuan-keringanan');
  }  
  public function pembayaranSPP(){
    return view('sikas.laporan-pembayaran-spp');
  }  
  public function pembayaranTabungan(){
    return view('sikas.laporan-pembayaran-tabungan');
  }  
}
