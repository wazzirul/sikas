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

class TabunganController extends Controller
{
    public function tabungan(){
        return view('sikas.transaksi-pembayaran-tabungan');
    }

    public function siswa(){
        $anggota = Anggota::where('tipe_anggota', 2)
            ->where('soft_delete', 0)
            ->inRandomOrder()
            ->limit(2)
            ->with('Kelas', 'Jurusan')
            ->get();

        return view('sikas.transaksi-pembayaran-tabungan-siswa', [
            'anggota' => $anggota,
        ]);
    }

    //TABUNGAN GURU 
    public function guru(){
        $anggota = Anggota::where('tipe_anggota', 1)
            ->where('soft_delete', 0)
            ->inRandomOrder()
            ->limit(2)
            ->with('Jabatan')
            ->get();

        return view('sikas.transaksi-pembayaran-tabungan-guru', [
            'anggota' => $anggota,
        ]);
    }
}
