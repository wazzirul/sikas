<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaksi;
use App\Models\PengajuanKeringanan;

class LaporanController extends Controller
{
  public function index(){
    return view('sikas.laporan');
  }

  public function penggunaanDana(){
    $laporan = Transaksi::where('tipe_transaksi', 4)
        ->where('soft_delete', 0)
        ->get();

    return view('sikas.laporan-penggunaan-dana', [
      'laporan' => $laporan,
    ]);
  }  

  public function pemasukanSumberLain(){
    $laporan = Transaksi::where('tipe_transaksi', 5)
        ->where('soft_delete', 0)
        ->get();

    return view('sikas.laporan-pemasukan-sumber-lain', [
      'laporan' => $laporan,
    ]);
  }  

  public function pengajuanKeringanan(){
    $laporan = PengajuanKeringanan::where('soft_delete', 0)
      ->with('Anggota.Kelas', 'Anggota.Jurusan')
      ->get();

    return view('sikas.laporan-pengajuan-keringanan', [
      'laporan' => $laporan,
    ]);
  }  

  public function pembayaranSPP(){
    $laporan = Transaksi::where('tipe_transaksi', 1)
      ->where('soft_delete', 0)
      ->with('Anggota.Kelas', 'Anggota.Jurusan')
      ->get();

    return view('sikas.laporan-pembayaran-spp', [
      'laporan' => $laporan,
    ]);
  }  

  public function pembayaranTabungan(){
    $laporan = Transaksi::where('tipe_transaksi', '>=', 2)
      ->where('tipe_transaksi', '<=', 3)
      ->where('soft_delete', 0)
      ->with('Anggota.Kelas', 'Anggota.Jurusan', 'Anggota.Jabatan')
      ->get();

    return view('sikas.laporan-pembayaran-tabungan', [
      'laporan' => $laporan,
    ]);
  } 
   
}
