<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportDinamis;

use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Tagihan;

class PembayaranDinamisController extends Controller
{
	public function pembayaranDinamis($id)
	{
		$anggota = Anggota::where('tipe_anggota', 2)
				->where('soft_delete', 0)
				->inRandomOrder()
				->limit(20)
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

		$dinamis = Tagihan::find($id);

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

		return view('sikas.transaksi-dinamis', [
			'dinamis' => $dinamis,
			'anggota' => $anggota,
			'kelas' => $kelas,
			'jurusan' => $jurusan,
			'nomor_kelas' => $nomor_kelas,
			'all_angkatan' => $all_angkatan,
		]);
	}

	public function importDinamis(Request $request){
		ini_set('memory_limit', '3000M');
		ini_set('max_execution_time', '0');
		$id_tagihan = $request->input('id_tagihan');
		Excel::import(new ImportDinamis($id_tagihan), $request->file('file')->store('files'));
	
		return redirect('/transaksi/dinamis/'.$id_tagihan);
	}
}
