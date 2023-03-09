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

    return view('sikas.siswa', [
      'anggota' => $anggota,
      'kelas' => $kelas,
      'jurusan' => $jurusan,
      'nomor_kelas' => $nomor_kelas,
      'all_angkatan' => $all_angkatan,
    ]);
  }

  public function postSiswa(Request $request){
    $nama_siswa = $request->input('nama_siswa');
    $nis = $request->input('nis');
    $tahun_ajaran = $request->input('tahun_ajaran');
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
      $tahun_ajaran = str_replace('/', '-', $tahun_ajaran);
      $bulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari',
         'Maret', 'April', 'Mei', 'Juni'];

      $total_tagihan_bulanan = round((int)$tagihan->jumlah / 12);

      foreach($bulan as $b){
        $history_bulanan = new HistoryTagihanBulanan();
        $history_bulanan->tahun_ajaran = $tahun_ajaran;
        $history_bulanan->id_anggota = $siswa->id_anggota;
        $history_bulanan->id_tagihan = $tagihan->id_tagihan;
        $history_bulanan->bulan = $b;
        $history_bulanan->jumlah = $total_tagihan_bulanan;
        $history_bulanan->save();
      }

      if($id_kelas >= 2){
        $explode_tahun_ajaran = explode("-", $tahun_ajaran);
        $tahun_ajaran_last = (int)$explode_tahun_ajaran[0] - 1;
        $tahun_ajaran_siswa = (string)$tahun_ajaran_last."-".$explode_tahun_ajaran[0];
        foreach($bulan as $b){
            $history_bulanan = HistoryTagihanBulanan::where('id_anggota', $siswa->id_anggota)
                ->where('tahun_ajaran', $tahun_ajaran_siswa)
                ->where('id_tagihan', $tagihan->id_tagihan)
                ->where('bulan', $b)
                ->first();

            if($history_bulanan){
                $history_bulanan->soft_delete = 0;
            }else{
                $history_bulanan = new HistoryTagihanBulanan();
                $history_bulanan->id_anggota = $siswa->id_anggota;
                $history_bulanan->id_tagihan = $tagihan->id_tagihan;
            }
            
            $history_bulanan->tahun_ajaran = $tahun_ajaran_siswa;
            $history_bulanan->bulan = $b;
            $history_bulanan->jumlah = $total_tagihan_bulanan;
            $history_bulanan->status = 0;
            $history_bulanan->save();
        }

        if($id_kelas == 2){
            $explode_tahun_ajaran = explode("-", $tahun_ajaran);
            $tahun_ajaran_new = (int)$explode_tahun_ajaran[0] + 1;
            $tahun_ajaran_siswa = (string)$tahun_ajaran_new."-".(string)($tahun_ajaran_new + 1);
            foreach($bulan as $b){
                $history_bulanan = HistoryTagihanBulanan::where('id_anggota', $siswa->id_anggota)
                    ->where('tahun_ajaran', $tahun_ajaran_siswa)
                    ->where('id_tagihan', $tagihan->id_tagihan)
                    ->where('bulan', $b)
                    ->first();

                if($history_bulanan){
                    $history_bulanan->soft_delete = 0;
                }else{
                    $history_bulanan = new HistoryTagihanBulanan();
                    $history_bulanan->id_anggota = $siswa->id_anggota;
                    $history_bulanan->id_tagihan = $tagihan->id_tagihan;
                }
                
                $history_bulanan->tahun_ajaran = $tahun_ajaran_siswa;
                $history_bulanan->bulan = $b;
                $history_bulanan->jumlah = $total_tagihan_bulanan;
                $history_bulanan->status = 0;
                $history_bulanan->save();
            }
        }

        if($id_kelas == 3){
            $tahun_ajaran_last_2 = (int)$tahun_ajaran_last - 1;
            $tahun_ajaran_siswa = (string)$tahun_ajaran_last_2."-".$tahun_ajaran_last;
            foreach($bulan as $b){
                $history_bulanan = HistoryTagihanBulanan::where('id_anggota', $siswa->id_anggota)
                    ->where('tahun_ajaran', $tahun_ajaran_siswa)
                    ->where('id_tagihan', $tagihan->id_tagihan)
                    ->where('bulan', $b)
                    ->first();

                if($history_bulanan){
                    $history_bulanan->soft_delete = 0;
                }else{
                    $history_bulanan = new HistoryTagihanBulanan();
                    $history_bulanan->id_anggota = $siswa->id_anggota;
                    $history_bulanan->id_tagihan = $tagihan->id_tagihan;
                }
                
                $history_bulanan->tahun_ajaran = $tahun_ajaran_siswa;
                $history_bulanan->bulan = $b;
                $history_bulanan->jumlah = $total_tagihan_bulanan;
                $history_bulanan->status = 0;
                $history_bulanan->save();
            }
        }
    }else{
        if($id_kelas == 1){
            $explode_tahun_ajaran = explode("-", $tahun_ajaran);
            $tahun_ajaran_new = (int)$explode_tahun_ajaran[0] - 1;
            $tahun_ajaran_siswa = (string)$tahun_ajaran_new."-".$explode_tahun_ajaran[0];
            foreach($bulan as $b){
                $history_bulanan = HistoryTagihanBulanan::where('id_anggota', $siswa->id_anggota)
                    ->where('tahun_ajaran', $tahun_ajaran_siswa)
                    ->where('id_tagihan', $tagihan->id_tagihan)
                    ->where('bulan', $b)
                    ->first();

                if($history_bulanan){
                    $history_bulanan->soft_delete = 0;
                }else{
                    $history_bulanan = new HistoryTagihanBulanan();
                    $history_bulanan->id_anggota = $siswa->id_anggota;
                    $history_bulanan->id_tagihan = $tagihan->id_tagihan;
                }
                
                $history_bulanan->tahun_ajaran = $tahun_ajaran_siswa;
                $history_bulanan->bulan = $b;
                $history_bulanan->jumlah = $total_tagihan_bulanan;
                $history_bulanan->status = 0;
                $history_bulanan->save();
            }

            $tahun_ajaran_new_2 = (int)$tahun_ajaran_new - 1;
            $tahun_ajaran_siswa = (string)$tahun_ajaran_new_2."-".$tahun_ajaran_new;
            foreach($bulan as $b){
                $history_bulanan = HistoryTagihanBulanan::where('id_anggota', $siswa->id_anggota)
                    ->where('tahun_ajaran', $tahun_ajaran_siswa)
                    ->where('id_tagihan', $tagihan->id_tagihan)
                    ->where('bulan', $b)
                    ->first();

                if($history_bulanan){
                    $history_bulanan->soft_delete = 0;
                }else{
                    $history_bulanan = new HistoryTagihanBulanan();
                    $history_bulanan->id_anggota = $siswa->id_anggota;
                    $history_bulanan->id_tagihan = $tagihan->id_tagihan;
                }
                
                $history_bulanan->tahun_ajaran = $tahun_ajaran_siswa;
                $history_bulanan->bulan = $b;
                $history_bulanan->jumlah = $total_tagihan_bulanan;
                $history_bulanan->status = 0;
                $history_bulanan->save();
            }
        }
    }
    }

    return redirect('/siswa');
  }

  public function importSiswa(Request $request){
    Excel::import(new ImportSiswa, $request->file('file')->store('files'));

    return redirect('/siswa');
  }
}
