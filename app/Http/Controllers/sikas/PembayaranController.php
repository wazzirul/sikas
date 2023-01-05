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

class PembayaranController extends Controller
{
    public function transaksiPembayaran(){
        return view('sikas.transaksi-pembayaran');
    }

    public function historyTransaksiPembayaran($id){
        $anggota = Anggota::where('id_anggota', $id)
            ->with('Kelas','Jurusan','KeuanganAnggota')
            ->first();
        
        $history = Transaksi::where('id_anggota', $id)
            ->where('tipe_transaksi', 1)
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return view('sikas.history-transaksi-pembayaran', [
            'anggota' => $anggota,
            'history' => $history,
        ]);
    }
    
    public function pengajuanKeringananPembayaran($id){
        $anggota = $anggota = Anggota::where('id_anggota', $id)
            ->with('Kelas','Jurusan','KeuanganAnggota')
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

    public function postPengajuanKeringanan(Request $request){
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominalPembayaran');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        //menyimpan data file yang diupload ke variabel $file
        $file_pengajuan = $request->file('file-pengajuan');

        $nama_file = time()."_".$file_pengajuan->getClientOriginalName();

        //isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'uploads/file_pengajuan/';
        //upload file
        $file_pengajuan->move($tujuan_upload,$nama_file);

        $pengajuan = new PengajuanKeringanan();
        $pengajuan->id_anggota = $id_anggota;
        $pengajuan->jumlah = $nominal;
        $pengajuan->file = $tujuan_upload.$nama_file;
        $pengajuan->save();

        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
        $tanggungan = $keuangan_anggota->tagihan;
        $keuangan_anggota->tagihan = (int)$tanggungan - (int)$nominal;
        $keuangan_anggota->save();

        return redirect('/transaksi/pengajuan-keringanan/'.$id_anggota);
    }

    public function PembayaranAkademik(){
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

    public function postPembayaranAkademik(Request $request){
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominalPembayaran');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $anggota = Anggota::find($id_anggota);
        $tagihan = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
        $tanggungan = (int)$tagihan->tagihan;
        
        if((int)$nominal <= $tanggungan){
            $transaksi = new Transaksi();
            $transaksi->id_admin = Session::get('id_user');
            $transaksi->nomor_transaksi = '001000'.date('dmY');
            $transaksi->kode_transaksi = 'AKDMK-'.$id_anggota.'-'.date('hi-dmY');
            $transaksi->nama_transaksi = 'Pembayaran SPP';
            $transaksi->id_anggota = $id_anggota;
            $transaksi->tipe_transaksi = 1;
            $transaksi->jumlah = $nominal;
            $transaksi->id_kelas = $anggota->id_kelas;
            $transaksi->save();

            $tagihan->tagihan = $tanggungan - $nominal;
            $tagihan->save();

            $keuangan_sekolah = KeuanganSekolah::first();
            if(!$keuangan_sekolah){
                $keuangan_sekolah = new KeuanganSekolah();
                $keuangan_sekolah->pemasukan = $nominal;
                $keuangan_sekolah->total = $nominal;
            }else{
                $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan + (int)$nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$nominal;
            }
            $keuangan_sekolah->save();

            return redirect('/transaksi/history-pembayaran/'.$id_anggota);
        }else{
            return redirect()->back();
        }
    }

    //HISTORY TRANSAKSI SISWA
    public function historyTransaksiSiswa(){
        return view('sikas.history-transaksi-siswa');
    }
    public function historyTransaksiSiswaDetail(){
        return view('sikas.history-transaksi-siswa-detail');
    }
}
