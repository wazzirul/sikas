<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportTabunganSiswa;
use App\Imports\ImportTabunganGuru;

use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\PengajuanKeringanan;
use App\Models\Transaksi;

class TabunganController extends Controller
{
    public function tabungan(){
        $tabungan_siswa = Transaksi::where('soft_delete', 0)
            ->with(['Anggota'])
                ->whereHas('Anggota', function($q) {
                $q->where('anggota.tipe_anggota', '=', 2); 
            })
            ->with('Anggota.Kelas', 'Anggota.Jurusan')
            ->where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->with('Admin')
            ->orderBy('id_transaksi', 'DESC')
            ->limit(10)
            ->get();

        $tabungan_guru = Transaksi::where('soft_delete', 0)
            ->with(['Anggota'])
                ->whereHas('Anggota', function($q) {
                $q->where('anggota.tipe_anggota', '=', 1); 
            })
            ->with('Anggota.Jabatan')
            ->where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->with('Admin')
            ->orderBy('id_transaksi', 'DESC')
            ->limit(10)
            ->get();

        return view('sikas.transaksi-pembayaran-tabungan', [
            'tabungan_siswa' => $tabungan_siswa,
            'tabungan_guru' => $tabungan_guru,
        ]);
    }

    public function siswa(){
        $anggota = Anggota::where('tipe_anggota', 2)
            ->where('soft_delete', 0)
            ->inRandomOrder()
            ->limit(2)
            ->with('Kelas', 'Jurusan')
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

        return view('sikas.transaksi-pembayaran-tabungan-siswa', [
            'anggota' => $anggota,
            'kelas' => $kelas,
            'jurusan' => $jurusan,
            'nomor_kelas' => $nomor_kelas,
            'all_angkatan' => $all_angkatan,
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

    public function importTabunganSiswa(Request $request){
		Excel::import(new ImportTabunganSiswa, $request->file('file')->store('files'));
	
		return redirect('/transaksi/tabungan/siswa');
	}

    public function importTabunganGuru(Request $request){
		Excel::import(new ImportTabunganGuru, $request->file('file')->store('files'));
	
		return redirect('/transaksi/tabungan/guru');
	}
}
