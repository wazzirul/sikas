<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tagihan;
use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\HistoryTagihanBulanan;

class JenisPembayaranController extends Controller
{
    //
  public function index(){
    $tagihan = Tagihan::where('soft_delete', 0)
      ->with('Kelas')
      ->get();

    $kelas = Kelas::where('soft_delete', 0)
      ->get();

    $angkatan = Anggota::where('soft_delete', 0)
      ->where('angkatan', '!=', null)
      ->orderBy('angkatan', 'DESC')
      ->select('angkatan')
      ->first();

    $angkatan_bawah = Anggota::where('soft_delete', 0)
      ->where('angkatan', '!=', null)
      ->orderBy('angkatan', 'ASC')
      ->select('angkatan')
      ->first();

    if($angkatan == null) $angkatan = ((int)date('Y') - 1).'-'.date('Y');
    else $angkatan = $angkatan->angkatan;
    $angkatan = explode('-', $angkatan);
    $angkatan_siswa = $angkatan[1];

    if($angkatan_bawah == null) $angkatan_bawah = '2015-2016';
    else $angkatan_bawah = $angkatan_bawah->angkatan;
    $angkatan_bawah = explode('-', $angkatan_bawah);
    $angkatan_siswa_bawah = $angkatan_bawah[1];

    $all_angkatan = [];
    for($i = $angkatan_siswa; $i >= $angkatan_siswa_bawah; $i--){
      $angkatan_sekarang = strval(($i - 1).'-'.$i);
      array_push($all_angkatan, $angkatan_sekarang);
    }

    return view('sikas.jenis-pembayaran', [
      'tagihan' => $tagihan,
      'kelas' => $kelas,
      'all_angkatan' => $all_angkatan,
    ]);
  }

  public function postJenisPembayaran(Request $request){
    $nama = $request->input('nama');
    $id_kelas = $request->input('id_kelas');
    $status_siswa = $request->input('status_siswa');
    $angkatan = $request->input('angkatan');
    $jumlah = $request->input('jumlah');
    $jumlah = str_replace('Rp', '', $jumlah);
    $jumlah = str_replace('.', '', $jumlah);
    $jumlah = str_replace(' ', '', $jumlah);

    $tagihan_sama = Tagihan::where('nama', $nama)
      ->first();

    $tagihan = new Tagihan();
    $tagihan->nama = $nama;
    $tagihan->id_kelas = $id_kelas;
    $tagihan->jumlah = $jumlah;
    $tagihan->angkatan = $angkatan;
    $tagihan->tipe_tagihan = 2;

    if($status_siswa == 'aktif'){
      $tagihan->status = 1;
    }else{
      $tagihan->status = 2;
    }

    $tagihan->save();

    if($tagihan_sama) $tagihan->prefix_tagihan = $tagihan_sama->prefix_tagihan;
    else $tagihan->prefix_tagihan = $tagihan->id_tagihan;

    $tagihan->save();

    if($tagihan->status == 1){
      $anggota = Anggota::where('id_kelas', $id_kelas)
        ->where('alumni', 0)
        ->where('soft_delete', 0)
        ->get();

      foreach ($anggota as $a) {
        $history_bulanan = new HistoryTagihanBulanan();
        $history_bulanan->id_anggota = $a->id_anggota;
        $history_bulanan->id_tagihan = $tagihan->id_tagihan;
        $history_bulanan->prefix_tagihan = $tagihan->prefix_tagihan;
        $history_bulanan->jumlah = $tagihan->jumlah;
        $history_bulanan->save();
      }
    }

    return redirect('/jenis-transaksi');
  }
}
