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
		
		return view('sikas.transaksi-pembayaran-akademik', [
			'anggota' => $anggota,
			'kelas' => $kelas,
			'jurusan' => $jurusan,
			'nomor_kelas' => $nomor_kelas,
			'all_angkatan' => $all_angkatan,
		]);
	}

	public function PembayaranAkademikAlumni()
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
		
		return view('sikas.transaksi-pembayaran-akademik-alumni', [
			'anggota' => $anggota,
			'kelas' => $kelas,
			'jurusan' => $jurusan,
			'nomor_kelas' => $nomor_kelas,
			'all_angkatan' => $all_angkatan,
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

		$total_penambahan = 0;
		$penambahan = PengajuanPenambahan::where('id_anggota', $id)
				->where('soft_delete', 0)
				->get();

		foreach ($keringanan as $k) {
				$total_keringanan += (int)$k->jumlah;
		}

		foreach ($penambahan as $p) {
			$total_penambahan += (int)$p->jumlah;
		}

		return view('sikas.history-transaksi-siswa-detail', [
				'anggota' => $anggota,
				'transaksi' => $transaksi,
				'keringanan' => $keringanan,
				'penambahan' => $penambahan,
				'total_keringanan' => $total_keringanan,
				'total_penambahan' => $total_penambahan,
		]);
	}

	public function importBpp(Request $request){
		Excel::import(new ImportBPP, $request->file('file')->store('files'));
	
		return redirect('/transaksi/biaya-penunjang-pendidikan');
	}
}
