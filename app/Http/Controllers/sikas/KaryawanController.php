<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportKaryawan;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\StrukturSekolah;

class KaryawanController extends Controller
{
  public function index(){
    $karyawan = Anggota::where('tipe_anggota', 1)
      ->where('soft_delete', 0)
      ->with('Jabatan')
      ->orderBy('id_anggota', 'DESC')
      ->get();

    $jabatan = StrukturSekolah::where('soft_delete', 0)
      ->get();

    return view('sikas.karyawan', [
      'karyawan' => $karyawan,
      'jabatan' => $jabatan,
    ]);
  }

  public function postKaryawan(Request $request){
    $nama_karyawan = $request->input('nama_karyawan');
    $nip = $request->input('nip');
    $jabatan = $request->input('jabatan') ?? null;

    $karyawan = Anggota::where('nama', $nama_karyawan)
      ->where('nip', $nip)
      ->first();

    if($karyawan){
      $karyawan->soft_delete = '0';
      $karyawan->save();
    }else{
      $karyawan = new Anggota();
      $karyawan->tipe_anggota = 1;
      $karyawan->nama = $nama_karyawan;
      $karyawan->nip = $nip;
      $karyawan->save();
    }

    $keuangan_karyawan = KeuanganAnggota::where('id_anggota', $karyawan->id_anggota)
      ->first();
    if($keuangan_karyawan){
      $keuangan_karyawan->soft_delete = '0';
      $keuangan_karyawan->save();
    }else{
      $keuangan_karyawan = new KeuanganAnggota();
      $keuangan_karyawan->id_anggota = $karyawan->id_anggota;
      $keuangan_karyawan->save();
    }

    if($jabatan != null){
      $master_jabatan = StrukturSekolah::find($jabatan);
      $master_jabatan->id_anggota = $karyawan->id_anggota;
      $master_jabatan->save();
    }

    return redirect('/karyawan');
  }

  public function importKaryawan(Request $request){
    Excel::import(new ImportKaryawan, $request->file('file')->store('files'));

    return redirect('/karyawan');
  }
}
