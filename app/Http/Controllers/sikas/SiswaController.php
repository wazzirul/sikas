<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSiswa;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Tagihan;
use App\Models\HistoryTagihanBulanan;

class SiswaController extends Controller
{
  public function index(){
    $anggota = Anggota::where('tipe_anggota', 2)
      ->with('Kelas', 'Jurusan', 'KeuanganAnggota')
      ->where('soft_delete', 0)
      ->limit(100)
      ->get();

    $nomor_kelas = Anggota::where('soft_delete', 0)
      ->max('nomor_kelas');

    $kelas = Kelas::where('soft_delete', 0)
      ->get();

    $jurusan = Jurusan::where('soft_delete', 0)
      ->get();

    return view('sikas.siswa', [
      'anggota' => $anggota,
      'kelas' => $kelas,
      'jurusan' => $jurusan,
      'nomor_kelas' => $nomor_kelas,
    ]);
  }

  public function postSiswa(Request $request){
    $nama_siswa = $request->input('nama_siswa');
    $nis = $request->input('nis');
    $jenis_kelamin = $request->input('jenis_kelamin');
    $id_kelas = $request->input('id_kelas');
    $id_jurusan = $request->input('id_jurusan');
    $nomor_kelas = $request->input('nomor_kelas');
    $status_siswa = $request->input('status_siswa');

    $siswa = Anggota::where('nama', $nama_siswa)
      ->where('nis', $nis)
      ->first();

    if($siswa){
      $siswa->jenis_kelamin = $jenis_kelamin;
      $siswa->id_kelas = $id_kelas;
      $siswa->id_jurusan = $id_jurusan;
      $siswa->nomor_kelas = $nomor_kelas;
      $siswa->alumni = $status_siswa;
      $siswa->soft_delete = '0';
    }else{
      $siswa = new Anggota();
      $siswa->tipe_anggota = 2;
      $siswa->nama = $nama_siswa;
      $siswa->nis = $nis;
      $siswa->jenis_kelamin = $jenis_kelamin;
      $siswa->id_kelas = $id_kelas;
      $siswa->id_jurusan = $id_jurusan;
      $siswa->nomor_kelas = $nomor_kelas;
      $siswa->alumni = $status_siswa;
    }
    $siswa->save();

    $tagihan = Tagihan::where('id_kelas', $id_kelas)
      ->where('tipe_tagihan', 1)
      ->where('status', 1)
      ->first();
    
    $keuangan_siswa = KeuanganAnggota::where('id_anggota', $siswa->id_anggota)
      ->first();
    if($keuangan_siswa){
      $keuangan_siswa->tagihan = $tagihan->jumlah;
      $keuangan_siswa->tagihan_pertama = $tagihan->jumlah;
      $keuangan_siswa->tipe_tagihan = $tagihan->flow_tagihan;
      $keuangan_siswa->soft_delete = '0';
    }else{
      $keuangan_siswa = new KeuanganAnggota();
      $keuangan_siswa->id_anggota = $siswa->id_anggota;
      $keuangan_siswa->tagihan = $tagihan->jumlah;
      $keuangan_siswa->tagihan_pertama = $tagihan->jumlah;
      $keuangan_siswa->tipe_tagihan = $tagihan->flow_tagihan;
    }
    $keuangan_siswa->save();

    if($tagihan->flow_tagihan == 2){
      $bulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari',
         'Maret', 'April', 'Mei', 'Juni'];

      $total_tagihan_bulanan = round((int)$tagihan->jumlah / 12);

      foreach($bulan as $b){
        $history_bulanan = new HistoryTagihanBulanan();
        $history_bulanan->id_anggota = $siswa->id_anggota;
        $history_bulanan->id_tagihan = $tagihan->id_tagihan;
        $history_bulanan->bulan = $b;
        $history_bulanan->jumlah = $total_tagihan_bulanan;
        $history_bulanan->save();
      }
    }

    return redirect('/siswa');
  }

  public function importSiswa(Request $request){
    Excel::import(new ImportSiswa, $request->file('file')->store('files'));

    return redirect('/siswa');
  }
}
