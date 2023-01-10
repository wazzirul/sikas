<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\PengajuanKeringanan;
use App\Models\Transaksi;

class Main extends Controller
{
  public function index(){
    $siswa = Anggota::where('tipe_anggota', 2)
      ->where('soft_delete', 0)
      ->count();

    $guru = Anggota::where('tipe_anggota', 1)
      ->where('soft_delete', 0)
      ->count();

    $transaksi_spp = Transaksi::where('tipe_transaksi', 1)
      ->where('soft_delete', 0)
      ->count();

    $transaksi_lain = Transaksi::where('tipe_transaksi', '!=', 1)
      ->where('soft_delete', 0)
      ->count();

    $keringanan = PengajuanKeringanan::where('soft_delete', 0)
      ->sum('jumlah');

    $tabungan = KeuanganAnggota::where('soft_delete', 0)
      ->sum('tabungan');

    return view('sikas.dashboard', [
      'siswa' => $siswa,
      'guru' => $guru,
      'transaksi_spp' => $transaksi_spp,
      'transaksi_lain' => $transaksi_lain,
      'keringanan' => $keringanan,
      'tabungan' => $tabungan,
    ]);
  }
  public function TransaksiPemasukan(){
    $transaksi = Transaksi::where('tipe_transaksi', 5)
      ->where('soft_delete', 0)
      ->get();

    return view('sikas.transaksi-pemasukan', [
      'transaksi' => $transaksi,
    ]);
  }
  public function TransaksiPengeluaran(){
    $transaksi = Transaksi::where('tipe_transaksi', 4)
      ->where('soft_delete', 0)
      ->get();

    return view('sikas.transaksi-pengeluaran', [
      'transaksi' => $transaksi,
    ]);
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
