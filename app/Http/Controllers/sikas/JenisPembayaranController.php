<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tagihan;
use App\Models\Kelas;

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
    $jumlah = $request->input('jumlah');
    $jumlah = str_replace('Rp', '', $jumlah);
    $jumlah = str_replace('.', '', $jumlah);
    $jumlah = str_replace(' ', '', $jumlah);

    $tagihan = Tagihan::where('nama', $nama)
      ->where('id_kelas', $id_kelas)
      ->first();

    if($tagihan){
      $tagihan->jumlah = $jumlah;
      $tagihan->soft_delete = '0';
      $tagihan->save();
    }else{
      $tagihan = new Tagihan();
      $tagihan->nama = $nama;
      $tagihan->id_kelas = $id_kelas;
      $tagihan->jumlah = $jumlah;
      $tagihan->save();
    }

    return redirect('/jenis-pembayaran');
  }
}
