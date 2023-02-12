<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportBPP;

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

		return view('sikas.transaksi-dinamis', [
			'dinamis' => $dinamis,
			'anggota' => $anggota,
			'kelas' => $kelas,
			'jurusan' => $jurusan,
			'nomor_kelas' => $nomor_kelas,
		]);
	}
}
