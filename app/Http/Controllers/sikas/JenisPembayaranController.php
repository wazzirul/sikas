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

    return view('sikas.jenis-pembayaran', [
      'tagihan' => $tagihan,
      'kelas' => $kelas,
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

    $tagihan = new Tagihan();
    $tagihan->nama = $nama;
    $tagihan->id_kelas = $id_kelas;
    $tagihan->jumlah = $jumlah;

    if($status_siswa == 'aktif'){
      $tagihan->status = 1;
    }else{
      $tagihan->status = 2;
    }

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
        $history_bulanan->jumlah = $tagihan->jumlah;
        $history_bulanan->save();
      }
    }

    return redirect('/jenis-transaksi');
  }
}
