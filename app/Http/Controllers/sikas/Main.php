<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportPemasukan;
use App\Imports\ImportPengeluaran;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\PengajuanKeringanan;
use App\Models\StrukturSekolah;
use App\Models\Transaksi;

class Main extends Controller
{
  public function index(){
    $now = Carbon::now();
    $hari_ini = $now->copy()->toDateString();

    $transaksi_spp = Transaksi::where('tipe_transaksi', 1)
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_transaksi_spp = Transaksi::where('tipe_transaksi', 1)
      ->with('Anggota.Kelas', 'Anggota.Jurusan', 'Admin')
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->orderBy('id_transaksi', 'DESC')
      ->get();

    $tabungan_siswa = Transaksi::where('tipe_transaksi', 2)
      ->with(['Anggota'])
        ->whereHas('Anggota', function($q) {
        $q->where('anggota.tipe_anggota', '=', 2); 
      })
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_tabungan_siswa = Transaksi::where('tipe_transaksi', 2)
      ->with(['Anggota'])
        ->whereHas('Anggota', function($q) {
        $q->where('anggota.tipe_anggota', '=', 2); 
      })
      ->with('Anggota.Kelas', 'Anggota.Jurusan', 'Admin')
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->orderBy('id_transaksi', 'DESC')
      ->get();

    $tabungan_guru = Transaksi::where('tipe_transaksi', 2)
      ->with(['Anggota'])
        ->whereHas('Anggota', function($q) {
        $q->where('anggota.tipe_anggota', '=', 1); 
      })
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_tabungan_guru = Transaksi::where('tipe_transaksi', 2)
      ->with(['Anggota'])
        ->whereHas('Anggota', function($q) {
        $q->where('anggota.tipe_anggota', '=', 1); 
      })
      ->with('Anggota.Jabatan', 'Admin')
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->orderBy('id_transaksi', 'DESC')
      ->get();

    $transaksi_lain = Transaksi::where('tipe_transaksi', 5)
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_transaksi_lain = Transaksi::where('tipe_transaksi', 5)
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->with('Admin')
      ->orderBy('id_transaksi', 'DESC')
      ->get();

    $keringanan = PengajuanKeringanan::where('soft_delete', 0)
      ->whereDate('tanggal', $hari_ini)
      ->sum('jumlah');
    $data_keringanan = PengajuanKeringanan::where('soft_delete', 0)
      ->whereDate('tanggal', $hari_ini)
      ->with('Anggota.Kelas', 'Anggota.Jurusan')
      ->orderBy('id_pengajuan_keringanan', 'DESC')
      ->get();

    $pengeluaran = Transaksi::where('tipe_transaksi', '>=', 3)
      ->where('tipe_transaksi', '<=', 4)
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->sum('jumlah');
    $data_pengeluaran = Transaksi::where('tipe_transaksi', '>=', 3)
      ->where('tipe_transaksi', '<=', 4)
      ->whereDate('tanggal', $hari_ini)
      ->where('soft_delete', 0)
      ->with('Admin')
      ->orderBy('id_transaksi', 'DESC')
      ->get();

    return view('sikas.dashboard', [
      'transaksi_spp' => $transaksi_spp,
      'tabungan_siswa' => $tabungan_siswa,
      'tabungan_guru' => $tabungan_guru,
      'transaksi_lain' => $transaksi_lain,
      'keringanan' => $keringanan,
      'pengeluaran' => $pengeluaran,

      'data_transaksi_spp' => $data_transaksi_spp,
      'data_tabungan_siswa' => $data_tabungan_siswa,
      'data_tabungan_guru' => $data_tabungan_guru,
      'data_transaksi_lain' => $data_transaksi_lain,
      'data_keringanan' => $data_keringanan,
      'data_pengeluaran' => $data_pengeluaran,
    ]);
  }
  public function TransaksiPemasukan(){
    $transaksi = Transaksi::where('tipe_transaksi', 5)
      ->where('soft_delete', 0)
      ->with('Admin')
      ->orderBy('id_transaksi', 'DESC')
      ->get();

    return view('sikas.transaksi-pemasukan', [
      'transaksi' => $transaksi,
    ]);
  }
  public function TransaksiPengeluaran(){
    $transaksi = Transaksi::where('tipe_transaksi', 4)
      ->where('soft_delete', 0)
      ->with('Admin')
      ->orderBy('id_transaksi', 'DESC')
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

  public function importPemasukan(Request $request){
		Excel::import(new ImportPemasukan, $request->file('file')->store('files'));
	
		return redirect('/transaksi/pemasukan');
	}

  public function importPengeluaran(Request $request){
		Excel::import(new ImportPengeluaran, $request->file('file')->store('files'));
	
		return redirect('/transaksi/pengeluaran');
	}
  
}
