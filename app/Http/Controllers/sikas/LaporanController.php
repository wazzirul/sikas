<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Transaksi;
use App\Models\PengajuanKeringanan;
use App\Models\KeuanganSekolah;

class LaporanController extends Controller
{
  public function index(){
    $now = Carbon::now();
    $startDate = $now->copy()->firstOfMonth()->toDateString();
    $endDate = $now->copy()->endOfMonth()->toDateString();

    $total_tabungan = Transaksi::where('tipe_transaksi', 2)
      ->where('soft_delete', 0)
      ->sum('jumlah');

    $tarik_tabungan = Transaksi::where('tipe_transaksi', 3)
      ->where('soft_delete', 0)
      ->sum('jumlah');

    $keuangan_sekolah = KeuanganSekolah::first();
    if($keuangan_sekolah){
      $total_keuangan_sekolah = $keuangan_sekolah->total;
    }else{
      $total_keuangan_sekolah = 0;
    }

    $tabungan_sekolah = (int) $total_tabungan - (int) $tarik_tabungan;
    $bpp_sekolah = (int) $total_keuangan_sekolah - (int) $tabungan_sekolah;

    $tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 2)
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 2)
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('soft_delete', 0)
      ->orderBy('id_transaksi', 'DESC')
      ->first();

    $tarik_tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 3)
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_tarik_tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 3)
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('soft_delete', 0)
      ->orderBy('id_transaksi', 'DESC')
      ->first();

    $spp_bulan_ini = Transaksi::where('tipe_transaksi', 1)
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_spp_bulan_ini = Transaksi::where('tipe_transaksi', 1)
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('soft_delete', 0)
      ->orderBy('id_transaksi', 'DESC')
      ->first();

    $transaksi_lain_bulan_ini = Transaksi::where('tipe_transaksi', '>=', 4)
      ->where('tipe_transaksi', '<=', 5)
      ->whereDate('tanggal', '>=', $startDate)
      ->whereDate('tanggal', '<=', $endDate)
      ->where('soft_delete', 0)
      ->orderBy('id_transaksi', 'DESC')
      ->get();
      
    return view('sikas.laporan', [
      'bpp_sekolah' => $bpp_sekolah,
      'tabungan_sekolah' => $tabungan_sekolah,
      'tabungan_bulan_ini' => $tabungan_bulan_ini,
      'tarik_tabungan_bulan_ini' => $tarik_tabungan_bulan_ini,
      'spp_bulan_ini' => $spp_bulan_ini,
      'transaksi_lain_bulan_ini' => $transaksi_lain_bulan_ini,
      'data_tabungan_bulan_ini' => $data_tabungan_bulan_ini,
      'data_tarik_tabungan_bulan_ini' => $data_tarik_tabungan_bulan_ini,
      'data_spp_bulan_ini' => $data_spp_bulan_ini,
    ]);
  }

  public function penggunaanDana(){
    $laporan = Transaksi::where('tipe_transaksi', 4)
      ->with('Admin')
      ->where('soft_delete', 0)
      ->get();

    return view('sikas.laporan-penggunaan-dana', [
      'laporan' => $laporan,
    ]);
  }  

  public function pemasukanSumberLain(){
    $laporan = Transaksi::where('tipe_transaksi', 5)
      ->with('Admin')
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

  public function pengajuanPenambahan(){
    $laporan = PengajuanKeringanan::where('soft_delete', 0)
      ->with('Anggota.Kelas', 'Anggota.Jurusan')
      ->get();

    return view('sikas.laporan-pengajuan-penambahan', [
      'laporan' => $laporan,
    ]);
  }  

  public function pembayaranSPP(){
    $laporan = Transaksi::where('tipe_transaksi', 1)
      ->where('soft_delete', 0)
      ->with('Anggota.Kelas', 'Anggota.Jurusan', 'Admin')
      ->get();

    $kelas = Kelas::where('soft_delete', 0)
      ->orderBy('nama', 'ASC')
      ->get();

    $jurusan = Jurusan::where('soft_delete', 0)
      ->orderBy('nama', 'ASC')
      ->get();

    $nomor_kelas = Anggota::where('tipe_anggota', 2)
      ->where('soft_delete', 0)
      ->max('nomor_kelas');

    return view('sikas.laporan-pembayaran-spp', [
      'laporan' => $laporan,
      'kelas' => $kelas,
      'jurusan' => $jurusan,
      'nomor_kelas' => $nomor_kelas,
    ]);
  }  

  public function pembayaranTabungan(){
    $laporan = Transaksi::where('tipe_transaksi', '>=', 2)
      ->where('tipe_transaksi', '<=', 3)
      ->where('soft_delete', 0)
      ->with('Anggota.Kelas', 'Anggota.Jurusan', 'Anggota.Jabatan', 'Admin')
      ->get();

    return view('sikas.laporan-pembayaran-tabungan', [
      'laporan' => $laporan,
    ]);
  } 
   
}
