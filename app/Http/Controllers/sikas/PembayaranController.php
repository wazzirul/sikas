<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\PengajuanKeringanan;
use App\Models\PengajuanPenambahan;
use App\Models\Transaksi;

class PembayaranController extends Controller
{
	public function transaksiPembayaran()
	{
		$transaksi_akademik = Transaksi::where('tipe_transaksi', 1)
				->with('Anggota')
				->where('soft_delete', 0)
				->orderBy('id_transaksi', 'DESC')
				->get();

		$transaksi_tabungan = Transaksi::where('tipe_transaksi', '>=', 2)
				->where('tipe_transaksi', '<=', 3)
				->with('Anggota')
				->where('soft_delete', 0)
				->orderBy('id_transaksi', 'DESC')
				->get();

		return view('sikas.transaksi-pembayaran', [
				'transaksi_akademik' => $transaksi_akademik,
				'transaksi_tabungan' => $transaksi_tabungan,
		]);
	}

	public function historyTransaksiPembayaran($id)
	{
		$anggota = Anggota::where('id_anggota', $id)
				->with('Kelas', 'Jurusan', 'KeuanganAnggota')
				->first();

		$history = Transaksi::where('id_anggota', $id)
				->where('tipe_transaksi', 1)
				->where('soft_delete', 0)
				->orderBy('id_transaksi', 'DESC')
				->get();

		$total_keringanan = 0;
		$keringanan = PengajuanKeringanan::where('id_anggota', $id)
				->where('soft_delete', 0)
				->get();

		foreach ($keringanan as $k) {
				$total_keringanan += (int)$k->jumlah;
		}

		return view('sikas.history-transaksi-pembayaran', [
				'anggota' => $anggota,
				'history' => $history,
				'total_keringanan' => $total_keringanan,
		]);
	}

	public function pengajuanKeringananPembayaran($id)
	{
		$anggota = $anggota = Anggota::where('id_anggota', $id)
				->with('Kelas', 'Jurusan', 'KeuanganAnggota')
				->first();

		$history = PengajuanKeringanan::where('id_anggota', $id)
				->where('soft_delete', 0)
				->orderBy('id_pengajuan_keringanan', 'DESC')
				->get();

		return view('sikas.transaksi-pengajuan-keringanan-akademik', [
			'anggota' => $anggota,
			'history' => $history,
		]);
	}
	
	public function pengajuanPenambahanPembayaran($id){
		$anggota = $anggota = Anggota::where('id_anggota', $id)
				->with('Kelas', 'Jurusan', 'KeuanganAnggota')
				->first();

		$history = PengajuanPenambahan::where('id_anggota', $id)
				->where('soft_delete', 0)
				->orderBy('id_pengajuan_penambahan', 'DESC')
				->get();

		return view('sikas.transaksi-pengajuan-penambahan-akademik', [
			'anggota' => $anggota,
			'history' => $history,
		]);
	}

	public function PembayaranAkademik()
	{
		$anggota = Anggota::where('tipe_anggota', 2)
				->where('soft_delete', 0)
				->inRandomOrder()
				->limit(3)
				->with('Kelas', 'Jurusan')
				->get();

		return view('sikas.transaksi-pembayaran-akademik', [
				'anggota' => $anggota,
		]);
	}

	//HISTORY TRANSAKSI SISWA
	public function historyTransaksiSiswa()
	{
		return view('sikas.history-transaksi-siswa');
	}

	public function historyTransaksiSiswaDetail($id)
	{
		$anggota = Anggota::where('id_anggota', $id)
				->with('Kelas', 'Jurusan', 'KeuanganAnggota')
				->first();

		$transaksi = Transaksi::where('id_anggota', $id)
				->where('soft_delete', 0)
				->orderBy('id_transaksi', 'DESC')
				->get();

		$total_keringanan = 0;
		$keringanan = PengajuanKeringanan::where('id_anggota', $id)
				->where('soft_delete', 0)
				->get();

		foreach ($keringanan as $k) {
				$total_keringanan += (int)$k->jumlah;
		}

		return view('sikas.history-transaksi-siswa-detail', [
				'anggota' => $anggota,
				'transaksi' => $transaksi,
				'total_keringanan' => $total_keringanan,
		]);
	}
}
