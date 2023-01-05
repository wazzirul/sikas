<?php

namespace App\Http\Controllers\sikas\Query;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\Transaksi;

class QueryController extends Controller
{
    public function dataSiswa(Request $request){
        $search = $request->input('search');
        $limit = $request->input('limit');
        $anggota = Anggota::where('nama', 'LIKE', '%'.$search.'%')
            ->orWhere('nisn', 'LIKE', '%'.$search.'%')
            ->where('tipe_anggota', 2)
            ->where('soft_delete', 0)
            ->inRandomOrder()
            ->limit($limit)
            ->with('Kelas', 'Jurusan')
            ->get();

        return response($anggota, 200);
    }

    public function siswaById(Request $request){
        $id = $request->input('id');
        $anggota = Anggota::where('id_anggota', $id)
            ->with('Kelas', 'Jurusan', 'KeuanganAnggota')
            ->get();

        return response($anggota, 200);
    }

    public function setorTabunganSiswa(Request $request){
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();

        $transaksi = new Transaksi();
        $transaksi->id_admin = Session::get('id_user');
        $transaksi->nomor_transaksi = '002000'.date('dmY');
        $transaksi->kode_transaksi = 'TBNGN-'.$id_anggota.'-'.date('hi-dmY');
        $transaksi->nama_transaksi = 'Setoran Tabungan';
        $transaksi->id_anggota = $id_anggota;
        $transaksi->tipe_transaksi = 2;
        $transaksi->jumlah = (int)$nominal;

        $keuangan_sekolah = KeuanganSekolah::first();
        if(!$keuangan_sekolah){
            $keuangan_sekolah = new KeuanganSekolah();
            $keuangan_sekolah->pemasukan = $nominal;
            $keuangan_sekolah->total = $nominal;
        }else{
            $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan + (int)$nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$nominal;
        }

        $tabungan_anggota = $keuangan_anggota->tabungan ?? 0;
        $keuangan_anggota->tabungan = (int)$tabungan_anggota + (int)$nominal;
        $transaksi->mutasi = (int)$tabungan_anggota + (int)$nominal;

        $transaksi->save();
        $keuangan_sekolah->save();
        $keuangan_anggota->save();

        return response($keuangan_anggota, 200);
    }

    public function penarikanTabunganSiswa(Request $request){
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();

        $transaksi = new Transaksi();
        $transaksi->id_admin = Session::get('id_user');
        $transaksi->nomor_transaksi = '002000'.date('dmY');
        $transaksi->kode_transaksi = 'TBNGN-'.$id_anggota.'-'.date('hi-dmY');
        $transaksi->nama_transaksi = 'Penarikan Tabungan';
        $transaksi->id_anggota = $id_anggota;
        $transaksi->tipe_transaksi = 3;
        $transaksi->jumlah = (int)$nominal;

        $keuangan_sekolah = KeuanganSekolah::first();
        if(!$keuangan_sekolah){
            $keuangan_sekolah = new KeuanganSekolah();
            $keuangan_sekolah->pengeluaran = $nominal;
            $keuangan_sekolah->total = 0 - $nominal;
        }else{
            $keuangan_sekolah->pengeluaran = (int)$keuangan_sekolah->pengeluaran + (int)$nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$nominal;
        }

        $tabungan_anggota = $keuangan_anggota->tabungan ?? 0;
        $keuangan_anggota->tabungan = (int)$tabungan_anggota - (int)$nominal;
        $transaksi->mutasi = (int)$tabungan_anggota - (int)$nominal;

        $transaksi->save();
        $keuangan_sekolah->save();
        $keuangan_anggota->save();

        return response($keuangan_anggota, 200);
    }

    public function riwayatTabungan(Request $request){
        $id_anggota = $request->input('id_anggota');
        $transaksi = Transaksi::where('id_anggota', $id_anggota)
            ->where('soft_delete', 0)
            ->where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return response($transaksi, 200);
    }

    public function updateHistoryPembayaran(Request $request){
        $id_transaksi = $request->input('id_transaksi');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $transaksi = Transaksi::find($id_transaksi);
        $nominal_awal = $transaksi->jumlah;
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $transaksi->id_anggota)->first();

        if((int)$nominal_awal >= (int)$nominal){
            $selisih_nominal = (int)$nominal_awal - (int)$nominal;
            $tagihan_awal = $keuangan_anggota->tagihan;
            $keuangan_anggota->tagihan = (int)$tagihan_awal + (int)$selisih_nominal;
            $transaksi->jumlah = $nominal;
        }else{
            $selisih_nominal = (int)$nominal - (int)$nominal_awal;
            $tagihan_awal = $keuangan_anggota->tagihan;
            $keuangan_anggota->tagihan = (int)$tagihan_awal - (int)$selisih_nominal;
            $transaksi->jumlah = $nominal;
        }

        $transaksi->save();
        $keuangan_anggota->save();

        return response($transaksi, 200);
    }

    public function deleteHistoryPembayaran(Request $request){
        $id_transaksi = $request->input('id_transaksi');
        $transaksi = Transaksi::find($id_transaksi);
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $transaksi->id_anggota)->first();
        
        $nominal_awal = $transaksi->jumlah;
        $tagihan_awal = $keuangan_anggota->tagihan;
        $keuangan_anggota->tagihan = (int)$tagihan_awal + (int)$nominal_awal;
        $transaksi->soft_delete = 1;

        $transaksi->save();
        $keuangan_anggota->save();

        return response($transaksi, 200);
    }
}
