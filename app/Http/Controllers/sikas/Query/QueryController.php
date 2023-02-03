<?php

namespace App\Http\Controllers\sikas\Query;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Session;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\PengajuanKeringanan;
use App\Models\PengajuanPenambahan;
use App\Models\Transaksi;
use App\Models\StrukturSekolah;
use App\Models\Jurusan;
use App\Models\Tagihan;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon as Carbon;

class QueryController extends Controller
{
    public function dataSiswa(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('limit');
        $id_kelas = $request->input('id_kelas') ?? null;
        $id_jurusan = $request->input('id_jurusan');
        $nomor_kelas = $request->input('nomor_kelas');

        $anggota = Anggota::where(function ($query) use ($search) {
            $query->where('nama', 'LIKE', '%' . $search . '%');
            $query->orWhere('nis', 'LIKE', '%' . $search . '%');
        })
            ->where(function($q) use($id_kelas, $id_jurusan, $nomor_kelas){
                if($id_kelas != null){
                    if($id_kelas == 0){
                        $q->where('alumni', '=', 1);
                    }else{
                        $q->where('id_kelas', $id_kelas);
                    }
                }
                $id_jurusan && $q->where('id_jurusan', $id_jurusan);
                $nomor_kelas && $q->where('nomor_kelas', $nomor_kelas);
            })
            ->inRandomOrder()
            ->where('tipe_anggota', 2)
            ->where('soft_delete', 0)
            ->limit($limit)
            ->with('Kelas', 'Jurusan')
            ->get();

        return response($anggota, 200);
    }

    public function dataGuru(Request $request)
    {
        $search = $request->input('search');
        $limit = $request->input('limit');
        $anggota = Anggota::where(function ($query) use ($search) {
            $query->where('nama', 'LIKE', '%' . $search . '%');
            $query->orWhere('nip', 'LIKE', '%' . $search . '%');
        })
            ->inRandomOrder()
            ->where('tipe_anggota', 1)
            ->where('soft_delete', 0)
            ->limit($limit)
            ->with('Jabatan')
            ->get();

        return response($anggota, 200);
    }

    public function siswaById(Request $request)
    {
        $id = $request->input('id');
        $anggota = Anggota::where('id_anggota', $id)
            ->with('Kelas', 'Jurusan', 'KeuanganAnggota')
            ->first();

        return response($anggota, 200);
    }

    public function siswaByFilter(Request $request)
    {
        $id_kelas = $request->input('id_kelas') ?? null;
        $id_jurusan = $request->input('id_jurusan');
        $nomor_kelas = $request->input('nomor_kelas');

        $anggota = Anggota::where('tipe_anggota', 2)
            ->where(function($q) use($id_kelas, $id_jurusan, $nomor_kelas){
                if($id_kelas != null){
                    if($id_kelas == 0){
                        $q->where('alumni', '=', 1);
                    }else{
                        $q->where('id_kelas', $id_kelas);
                    }
                }
                
                $id_jurusan && $q->where('id_jurusan', '=', $id_jurusan);
                $nomor_kelas && $q->where('nomor_kelas', '=', $nomor_kelas);
            })
            ->with('Kelas', 'Jurusan', 'KeuanganAnggota')
            ->get();

        return response($anggota, 200);
    }

    public function guruById(Request $request)
    {
        $id = $request->input('id');
        $anggota = Anggota::where('id_anggota', $id)
            ->with('Jabatan', 'KeuanganAnggota')
            ->first();

        return response($anggota, 200);
    }

    public function tellerById(Request $request)
    {
        $id = $request->input('id');
        $teller = User::where('id_user', $id)
            ->first();

        return response($teller, 200);
    }

    public function strukturSekolahById(Request $request)
    {
        $id = $request->input('id');
        $struktur_sekolah = StrukturSekolah::where('id_struktur_sekolah', $id)
            ->first();

        return response($struktur_sekolah, 200);
    }

    public function jurusanById(Request $request)
    {
        $id = $request->input('id');
        $jurusan = Jurusan::where('id_jurusan', $id)
            ->first();

        return response($jurusan, 200);
    }

    public function jenisPembayaranById(Request $request)
    {
        $id = $request->input('id');
        $tagihan = Tagihan::where('id_tagihan', $id)
            ->first();

        return response($tagihan, 200);
    }

    public function postPembayaranAkademik(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominalPembayaran');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $anggota = Anggota::find($id_anggota);
        $tagihan = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
        $tanggungan = (int)$tagihan->tagihan;
        $master_tagihan = Tagihan::where('id_kelas', $anggota->id_kelas)
            ->first();

        if ((int)$nominal <= $tanggungan) {
            $transaksi = new Transaksi();
            $transaksi->id_admin = Session::get('id_user');
            $transaksi->nomor_transaksi = '001000' . date('dmY');
            $transaksi->kode_transaksi = 'AKDMK-' . $id_anggota . '-' . date('hi-dmY');
            $transaksi->nama_transaksi = $master_tagihan->nama;
            $transaksi->id_anggota = $id_anggota;
            $transaksi->tipe_transaksi = 1;
            $transaksi->jumlah = $nominal;
            $transaksi->id_kelas = $anggota->id_kelas;
            $transaksi->save();

            $tagihan->tagihan = $tanggungan - $nominal;
            $tagihan->save();

            $keuangan_sekolah = KeuanganSekolah::first();
            if (!$keuangan_sekolah) {
                $keuangan_sekolah = new KeuanganSekolah();
                $keuangan_sekolah->pemasukan = $nominal;
                $keuangan_sekolah->total = $nominal;
            } else {
                $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan + (int)$nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$nominal;
            }
            $keuangan_sekolah->save();

            $res_anggota = Anggota::where('id_anggota', $anggota->id_anggota)
                ->with('Kelas', 'Jurusan')
                ->first();

            $res_anggota['detail_kelas'] = $res_anggota->Kelas->nama . ' ' . $res_anggota->Jurusan->nama
                . ' ' . $res_anggota->nomor_kelas;

            $data['tanggal'] = Carbon::now()->format('l, d F Y');
            $data['anggota'] = $res_anggota;
            $data['transaksi'] = $transaksi;
            $data['kasir'] = Session::get('nama');
            return response($data, 200);
        } else {
            return response(null, 406);
        }
    }

    public function postPengajuanKeringanan(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominalPembayaran');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        //menyimpan data file yang diupload ke variabel $file
        $file_pengajuan = $request->file('file-pengajuan');

        $nama_file = time() . "_" . $file_pengajuan->getClientOriginalName();

        //isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'uploads/file_pengajuan/';
        //upload file
        $file_pengajuan->move($tujuan_upload, $nama_file);

        $pengajuan = new PengajuanKeringanan();
        $pengajuan->id_anggota = $id_anggota;
        $pengajuan->jumlah = $nominal;
        $pengajuan->file = $tujuan_upload . $nama_file;
        $pengajuan->save();

        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
        $tanggungan = $keuangan_anggota->tagihan;
        $keuangan_anggota->tagihan = (int)$tanggungan - (int)$nominal;
        $keuangan_anggota->save();

        $res_anggota = Anggota::where('id_anggota', $id_anggota)
            ->with('Kelas', 'Jurusan')
            ->first();

        $res_anggota['detail_kelas'] = $res_anggota->Kelas->nama . ' ' . $res_anggota->Jurusan->nama
            . ' ' . $res_anggota->nomor_kelas;

        $data['tanggal'] = Carbon::now()->format('l, d F Y');
        $data['anggota'] = $res_anggota;
        $data['pengajuan'] = $pengajuan;
        $data['kasir'] = Session::get('nama');

        return response($data, 200);
    }

    public function postPengajuanPenambahan(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominalPembayaran');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $pengajuan = new PengajuanPenambahan();
        $pengajuan->id_anggota = $id_anggota;
        $pengajuan->jumlah = $nominal;

        //menyimpan data file yang diupload ke variabel $file
        $file_pengajuan = $request->file('file-pengajuan');

        if($file_pengajuan){
            $nama_file = time() . "_" . $file_pengajuan->getClientOriginalName();
    
            //isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'uploads/file_pengajuan/';
            //upload file
            $file_pengajuan->move($tujuan_upload, $nama_file);
            
            $pengajuan->file = $tujuan_upload . $nama_file;
        }
        
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
        $tanggungan = $keuangan_anggota->tagihan;
        $keuangan_anggota->tagihan = (int)$tanggungan + (int)$nominal;

        $pengajuan->save();
        $keuangan_anggota->save();

        $res_anggota = Anggota::where('id_anggota', $id_anggota)
            ->with('Kelas', 'Jurusan')
            ->first();

        $res_anggota['detail_kelas'] = $res_anggota->Kelas->nama . ' ' . $res_anggota->Jurusan->nama
            . ' ' . $res_anggota->nomor_kelas;

        $data['tanggal'] = Carbon::now()->format('l, d F Y');
        $data['anggota'] = $res_anggota;
        $data['pengajuan'] = $pengajuan;
        $data['kasir'] = Session::get('nama');

        return response($data, 200);
    }

    public function updatePengajuanKeringanan(Request $request)
    {
        $id_pengajuan_keringanan = $request->input('id_pengajuan_keringanan');
        $nominal = $request->input('nominalKeringanan');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $pengajuan = PengajuanKeringanan::find($id_pengajuan_keringanan);
        if($pengajuan){
            $nominal_lama = $pengajuan->jumlah;
            
            //menyimpan data file yang diupload ke variabel $file
            $file_pengajuan = $request->file('file-pengajuan');

            $nama_file = time() . "_" . $file_pengajuan->getClientOriginalName();

            //isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'uploads/file_pengajuan/';
            //upload file
            $file_pengajuan->move($tujuan_upload, $nama_file);
            
            $pengajuan->jumlah = $nominal;
            $pengajuan->file = $tujuan_upload . $nama_file;
            $pengajuan->save();
    
            $id_anggota = $pengajuan->id_anggota;
            $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
            $tanggungan = $keuangan_anggota->tagihan;
            if((int)$nominal_lama > (int)$nominal){
                $keuangan_anggota->tagihan = (int)$tanggungan + ((int)$nominal_lama - (int)$nominal);
            }else{
                $keuangan_anggota->tagihan = (int)$tanggungan - ((int)$nominal - (int)$nominal_lama);
            }
            $keuangan_anggota->save();

            $res_anggota = Anggota::where('id_anggota', $id_anggota)
                ->with('Kelas', 'Jurusan')
                ->first();
    
            $res_anggota['detail_kelas'] = $res_anggota->Kelas->nama . ' ' . $res_anggota->Jurusan->nama
                . ' ' . $res_anggota->nomor_kelas;
    
            $data['tanggal'] = Carbon::now()->format('l, d F Y');
            $data['anggota'] = $res_anggota;
            $data['pengajuan'] = $pengajuan;
            $data['kasir'] = Session::get('nama');

            return response($data, 200);
        }else{
            $data['message'] = 'Data Pengajuan Tidak Ditemukan.';
            return response($data, 406);
        }
    }

    public function updatePengajuanPenambahan(Request $request)
    {
        $id_pengajuan_penambahan = $request->input('id_pengajuan_penambahan');
        $nominal = $request->input('nominalPenambahan');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $pengajuan = PengajuanPenambahan::find($id_pengajuan_penambahan);
        if($pengajuan){
            $nominal_lama = $pengajuan->jumlah;
            $pengajuan->jumlah = $nominal;
    
            //menyimpan data file yang diupload ke variabel $file
            $file_pengajuan = $request->file('file-pengajuan');
    
            if($file_pengajuan){
                $nama_file = time() . "_" . $file_pengajuan->getClientOriginalName();
        
                //isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'uploads/file_pengajuan/';
                //upload file
                $file_pengajuan->move($tujuan_upload, $nama_file);
                
                $pengajuan->file = $tujuan_upload . $nama_file;
            }

            $id_anggota = $pengajuan->id_anggota;
            $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
            $tanggungan = $keuangan_anggota->tagihan;
            if((int)$nominal_lama > (int)$nominal){
                $keuangan_anggota->tagihan = (int)$tanggungan - ((int)$nominal_lama - (int)$nominal);
            }else{
                $keuangan_anggota->tagihan = (int)$tanggungan + ((int)$nominal - (int)$nominal_lama);
            }
    
            $pengajuan->save();
            $keuangan_anggota->save();
    
            $res_anggota = Anggota::where('id_anggota', $id_anggota)
                ->with('Kelas', 'Jurusan')
                ->first();
    
            $res_anggota['detail_kelas'] = $res_anggota->Kelas->nama . ' ' . $res_anggota->Jurusan->nama
                . ' ' . $res_anggota->nomor_kelas;
    
            $data['tanggal'] = Carbon::now()->format('l, d F Y');
            $data['anggota'] = $res_anggota;
            $data['pengajuan'] = $pengajuan;
            $data['kasir'] = Session::get('nama');
    
            return response($data, 200);
        }else{
            $data['message'] = 'Data Pengajuan Tidak Ditemukan.';
            return response($data, 406);
        }
    }

    public function deletePengajuanKeringanan(Request $request)
    {
        $id_pengajuan_keringanan = $request->input('id_pengajuan_keringanan');

        $pengajuan = PengajuanKeringanan::find($id_pengajuan_keringanan);
        if($pengajuan){
            File::delete($pengajuan->file);

            $pengajuan->soft_delete = 1;

            $id_anggota = $pengajuan->id_anggota;
            $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
            $tanggungan = $keuangan_anggota->tagihan;
            $keuangan_anggota->tagihan = (int)$tanggungan + (int)$pengajuan->jumlah;

            $pengajuan->save();
            $keuangan_anggota->save();

            $data['message'] = 'Data Pengajuan Berhasil Dihapus.';
            return response($data, 200);
        }else{
            $data['message'] = 'Data Pengajuan Tidak Ditemukan.';
            return response($data, 406);
        }
    }

    public function deletePengajuanPenambahan(Request $request)
    {
        $id_pengajuan_penambahan = $request->input('id_pengajuan_penambahan');

        $pengajuan = PengajuanPenambahan::find($id_pengajuan_penambahan);
        if($pengajuan){
            File::delete($pengajuan->file);

            $pengajuan->soft_delete = 1;

            $id_anggota = $pengajuan->id_anggota;
            $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
            $tanggungan = $keuangan_anggota->tagihan;
            $keuangan_anggota->tagihan = (int)$tanggungan - (int)$pengajuan->jumlah;

            $pengajuan->save();
            $keuangan_anggota->save();
    
            $data['message'] = 'Data Pengajuan Berhasil Dihapus.';
            return response($data, 200);
        }else{
            $data['message'] = 'Data Pengajuan Tidak Ditemukan.';
            return response($data, 406);
        }
    }

    public function setorTabunganSiswa(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();

        $transaksi = new Transaksi();
        $transaksi->id_admin = Session::get('id_user');
        $transaksi->nomor_transaksi = '002000' . date('dmY');
        $transaksi->kode_transaksi = 'TBNGN-' . $id_anggota . '-' . date('hi-dmY');
        $transaksi->nama_transaksi = 'Setoran Tabungan';
        $transaksi->id_anggota = $id_anggota;
        $transaksi->tipe_transaksi = 2;
        $transaksi->jumlah = (int)$nominal;

        $keuangan_sekolah = KeuanganSekolah::first();
        if (!$keuangan_sekolah) {
            $keuangan_sekolah = new KeuanganSekolah();
            $keuangan_sekolah->pemasukan = $nominal;
            $keuangan_sekolah->total = $nominal;
        } else {
            $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan + (int)$nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$nominal;
        }

        $tabungan_anggota = $keuangan_anggota->tabungan ?? 0;
        $keuangan_anggota->tabungan = (int)$tabungan_anggota + (int)$nominal;
        $transaksi->mutasi = (int)$tabungan_anggota + (int)$nominal;

        $transaksi->save();
        $keuangan_sekolah->save();
        $keuangan_anggota->save();

        $res_anggota = Anggota::where('id_anggota', $id_anggota)
            ->with('Kelas', 'Jurusan', 'Jabatan')
            ->first();

        if ($res_anggota->tipe_anggota == 1) {
            $res_anggota['detail_kelas'] = $res_anggota->Jabatan->jabatan ?? 'Guru';
        } else {
            $res_anggota['detail_kelas'] = $res_anggota->Kelas->nama . ' ' . $res_anggota->Jurusan->nama
                . ' ' . $res_anggota->nomor_kelas;
        }

        $data['tanggal'] = Carbon::now()->format('l, d F Y');
        $data['anggota'] = $res_anggota;
        $data['transaksi'] = $transaksi;
        $data['kasir'] = Session::get('nama');

        return response($data, 200);
    }

    public function penarikanTabunganSiswa(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();

        $transaksi = new Transaksi();
        $transaksi->id_admin = Session::get('id_user');
        $transaksi->nomor_transaksi = '003000' . date('dmY');
        $transaksi->kode_transaksi = 'TBNGN-' . $id_anggota . '-' . date('hi-dmY');
        $transaksi->nama_transaksi = 'Penarikan Tabungan';
        $transaksi->id_anggota = $id_anggota;
        $transaksi->tipe_transaksi = 3;
        $transaksi->jumlah = (int)$nominal;

        if(Session::get('tipe_user') == 1){
            $keuangan_sekolah = KeuanganSekolah::first();
            if (!$keuangan_sekolah) {
                $keuangan_sekolah = new KeuanganSekolah();
                $keuangan_sekolah->pengeluaran = $nominal;
                $keuangan_sekolah->total = 0 - $nominal;
            } else {
                $keuangan_sekolah->pengeluaran = (int)$keuangan_sekolah->pengeluaran + (int)$nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$nominal;
            }
    
            $tabungan_anggota = $keuangan_anggota->tabungan ?? 0;
            $keuangan_anggota->tabungan = (int)$tabungan_anggota - (int)$nominal;
            $transaksi->mutasi = (int)$tabungan_anggota - (int)$nominal;

            $transaksi->approved = 1;

            $keuangan_sekolah->save();
            $keuangan_anggota->save();
        }else{
            $tabungan_anggota = $keuangan_anggota->tabungan ?? 0;
            $transaksi->mutasi = (int)$tabungan_anggota - (int)$nominal;

            $transaksi->approved = 0;
        }

        $transaksi->save();

        $res_anggota = Anggota::where('id_anggota', $id_anggota)
            ->with('Kelas', 'Jurusan', 'Jabatan')
            ->first();

        if ($res_anggota->tipe_anggota == 1) {
            $res_anggota['detail_kelas'] = $res_anggota->Jabatan->jabatan ?? 'Guru';
        } else {
            $res_anggota['detail_kelas'] = $res_anggota->Kelas->nama . ' ' . $res_anggota->Jurusan->nama
                . ' ' . $res_anggota->nomor_kelas;
        }

        $data['tanggal'] = Carbon::now()->format('l, d F Y');
        $data['anggota'] = $res_anggota;
        $data['transaksi'] = $transaksi;
        $data['kasir'] = Session::get('nama');

        return response($data, 200);
    }

    public function approvePenarikanTabunganSiswa(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $id_anggota = $request->input('id_anggota');
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)->first();
        $transaksi = Transaksi::find($id_transaksi);
        $nominal = (int)$transaksi->jumlah;
        
        $keuangan_sekolah = KeuanganSekolah::first();
        if (!$keuangan_sekolah) {
            $keuangan_sekolah = new KeuanganSekolah();
            $keuangan_sekolah->pengeluaran = $nominal;
            $keuangan_sekolah->total = 0 - $nominal;
        } else {
            $keuangan_sekolah->pengeluaran = (int)$keuangan_sekolah->pengeluaran + (int)$nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$nominal;
        }

        $tabungan_anggota = $keuangan_anggota->tabungan ?? 0;
        $keuangan_anggota->tabungan = (int)$tabungan_anggota - (int)$nominal;

        $transaksi->approved = 1;

        $keuangan_sekolah->save();
        $keuangan_anggota->save();
        $transaksi->save();

        // HISTORY
        $history = Transaksi::where('id_anggota', $id_anggota)
            ->where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->where('id_transaksi', '>', $id_transaksi)
            ->where('soft_delete', 0)
            ->get();

        foreach ($history as $h) {
            $mutasi_lama = $h->mutasi;
            $h->mutasi = (int)$mutasi_lama - (int)$nominal;
            $h->save();
        }

        return response($transaksi, 200);
    }

    public function riwayatPembayaranSpp(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $transaksi = Transaksi::where('id_anggota', $id_anggota)
            ->where('soft_delete', 0)
            ->where('tipe_transaksi', 1)
            ->with('Admin')
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return response($transaksi, 200);
    }

    public function riwayatTabungan(Request $request)
    {
        $id_anggota = $request->input('id_anggota');
        $transaksi = Transaksi::where('id_anggota', $id_anggota)
            ->where('soft_delete', 0)
            ->where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->with('Admin')
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return response($transaksi, 200);
    }

    public function updateHistoryPembayaran(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $transaksi = Transaksi::find($id_transaksi);
        $nominal_awal = $transaksi->jumlah;
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $transaksi->id_anggota)->first();
        $keuangan_sekolah = KeuanganSekolah::first();

        if ((int)$nominal_awal >= (int)$nominal) {
            $selisih_nominal = (int)$nominal_awal - (int)$nominal;
            $tagihan_awal = $keuangan_anggota->tagihan;
            $keuangan_anggota->tagihan = (int)$tagihan_awal + (int)$selisih_nominal;
            $transaksi->jumlah = $nominal;
            $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan - (int)$selisih_nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$selisih_nominal;
        } else {
            $selisih_nominal = (int)$nominal - (int)$nominal_awal;
            $tagihan_awal = $keuangan_anggota->tagihan;
            $keuangan_anggota->tagihan = (int)$tagihan_awal - (int)$selisih_nominal;
            $transaksi->jumlah = $nominal;
            $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan + (int)$selisih_nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$selisih_nominal;
        }

        $transaksi->save();
        $keuangan_anggota->save();
        $keuangan_sekolah->save();

        return response($transaksi, 200);
    }

    public function deleteHistoryPembayaran(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $transaksi = Transaksi::find($id_transaksi);
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $transaksi->id_anggota)->first();
        $keuangan_sekolah = KeuanganSekolah::first();

        $nominal_awal = $transaksi->jumlah;
        $tagihan_awal = $keuangan_anggota->tagihan;
        $keuangan_anggota->tagihan = (int)$tagihan_awal + (int)$nominal_awal;
        $transaksi->soft_delete = 1;
        $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan - (int)$nominal_awal;
        $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$nominal_awal;

        $transaksi->save();
        $keuangan_anggota->save();
        $keuangan_sekolah->save();

        return response($transaksi, 200);
    }

    public function updateHistoryTabungan(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $id_anggota = $request->input('id_anggota');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $transaksi = Transaksi::find($id_transaksi);
        $nominal_awal = $transaksi->jumlah;
        $keuangan_sekolah = KeuanganSekolah::first();
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $transaksi->id_anggota)->first();
        $selisih_nominal = 0;
        $validasi_nominal;

        if ((int)$nominal_awal >= (int)$nominal) {
            $selisih_nominal = (int)$nominal_awal - (int)$nominal;
            $tabungan_awal = $keuangan_anggota->tabungan;
            $mutasi_awal = $transaksi->mutasi;
            $transaksi->jumlah = $nominal;
            if ((int)$transaksi->tipe_transaksi == 2) {
                $keuangan_anggota->tabungan = (int)$tabungan_awal - (int)$selisih_nominal;
                $transaksi->mutasi = (int)$mutasi_awal - (int)$selisih_nominal;
                $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan - (int)$selisih_nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$selisih_nominal;
            } else {
                $transaksi->mutasi = (int)$mutasi_awal + (int)$selisih_nominal;
                if(Session::get('tipe_user') == 1){
                    $keuangan_anggota->tabungan = (int)$tabungan_awal + (int)$selisih_nominal;
                    $keuangan_sekolah->pengeluaran = (int)$keuangan_sekolah->pengeluaran + (int)$selisih_nominal;
                    $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$selisih_nominal;
                    $transaksi->approved = 1;
                }else{
                    $transaksi->approved = 0;
                }
            }
            $validasi_nominal = 'besar';
        } else {
            $selisih_nominal = (int)$nominal - (int)$nominal_awal;
            $tabungan_awal = $keuangan_anggota->tabungan;
            $mutasi_awal = $transaksi->mutasi;
            $transaksi->jumlah = $nominal;
            if ((int)$transaksi->tipe_transaksi == 2) {
                $keuangan_anggota->tabungan = (int)$tabungan_awal + (int)$selisih_nominal;
                $transaksi->mutasi = (int)$mutasi_awal + (int)$selisih_nominal;
                $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan + (int)$selisih_nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$selisih_nominal;
            } else {
                $transaksi->mutasi = (int)$mutasi_awal - (int)$selisih_nominal;
                if(Session::get('tipe_user') == 1){
                    $keuangan_anggota->tabungan = (int)$tabungan_awal - (int)$selisih_nominal;
                    $keuangan_sekolah->pengeluaran = (int)$keuangan_sekolah->pengeluaran - (int)$selisih_nominal;
                    $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$selisih_nominal;
                    $transaksi->approved = 1;
                }else{
                    $transaksi->approved = 0;
                }
            }
            $validasi_nominal = 'kecil';
        }

        $transaksi->save();
        $keuangan_anggota->save();

        // HISTORY
        $history = Transaksi::where('id_anggota', $id_anggota)
            ->where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->where('id_transaksi', '>', $id_transaksi)
            ->where('soft_delete', 0)
            ->get();

        foreach ($history as $h) {
            $mutasi_lama = $h->mutasi;
            if ((int)$transaksi->tipe_transaksi == 2) {
                if ($validasi_nominal == 'besar') {
                    $h->mutasi = (int)$mutasi_lama - (int)$selisih_nominal;
                } else {
                    $h->mutasi = (int)$mutasi_lama + (int)$selisih_nominal;
                }
            } else {
                if ($validasi_nominal == 'besar') {
                    $h->mutasi = (int)$mutasi_lama + (int)$selisih_nominal;
                } else {
                    $h->mutasi = (int)$mutasi_lama - (int)$selisih_nominal;
                }
            }
            $h->save();
        }

        return response($transaksi, 200);
    }

    public function deleteHistoryTabungan(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $id_anggota = $request->input('id_anggota');
        $transaksi = Transaksi::find($id_transaksi);
        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $transaksi->id_anggota)->first();

        $nominal_awal = $transaksi->jumlah;
        $tabungan_awal = $keuangan_anggota->tabungan;
        if ((int)$transaksi->tipe_transaksi == 2) {
            $keuangan_anggota->tabungan = (int)$tabungan_awal - (int)$nominal_awal;
        } else {
            if($transaksi->approved == 1) $keuangan_anggota->tabungan = (int)$tabungan_awal + (int)$nominal_awal;
        }
        $transaksi->soft_delete = 1;

        $transaksi->save();
        $keuangan_anggota->save();

        // HISTORY
        $history = Transaksi::where('id_anggota', $id_anggota)
            ->where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->where('id_transaksi', '>', $id_transaksi)
            ->where('soft_delete', 0)
            ->get();

        foreach ($history as $h) {
            $mutasi_lama = $h->mutasi;
            if ((int)$transaksi->tipe_transaksi == 2) {
                $h->mutasi = (int)$mutasi_lama - (int)$nominal_awal;
            } else {
                $h->mutasi = (int)$mutasi_lama + (int)$nominal_awal;
            }
            $h->save();
        }

        return response($transaksi, 200);
    }

    public function pengeluaran(Request $request)
    {
        $keterangan = $request->input('keterangan');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $transaksi = new Transaksi();
        $transaksi->id_admin = Session::get('id_user');
        $transaksi->nomor_transaksi = '004000' . date('dmY');
        $transaksi->kode_transaksi = 'PNGLRN' . date('hi-dmY');
        $transaksi->nama_transaksi = $keterangan;
        $transaksi->tipe_transaksi = 4;
        $transaksi->jumlah = (int)$nominal;

        $keuangan_sekolah = KeuanganSekolah::first();
        if(Session::get('tipe_user') == 1){
            if (!$keuangan_sekolah) {
                $keuangan_sekolah = new KeuanganSekolah();
                $keuangan_sekolah->pengeluaran = $nominal;
                $keuangan_sekolah->total = $nominal;
            } else {
                $keuangan_sekolah->pengeluaran = (int)$keuangan_sekolah->pengeluaran + (int)$nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$nominal;
            }

            $transaksi->approved = 1;
        }else{
            $transaksi->approved = 0;
        }

        $transaksi->save();
        $keuangan_sekolah->save();

        return response($keuangan_sekolah, 200);
    }

    public function approvePengeluaran(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $transaksi = Transaksi::find($id_transaksi);
        $nominal = (int)$transaksi->jumlah;
        
        $keuangan_sekolah = KeuanganSekolah::first();
        if (!$keuangan_sekolah) {
            $keuangan_sekolah = new KeuanganSekolah();
            $keuangan_sekolah->pengeluaran = $nominal;
            $keuangan_sekolah->total = $nominal;
        } else {
            $keuangan_sekolah->pengeluaran = (int)$keuangan_sekolah->pengeluaran + (int)$nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$nominal;
        }

        $transaksi->approved = 1;

        $transaksi->save();
        $keuangan_sekolah->save();

        return response($keuangan_sekolah, 200);
    }

    public function updatePengeluaran(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $transaksi = Transaksi::find($id_transaksi);
        $keuangan_sekolah = KeuanganSekolah::first();
        $nominal_awal = $transaksi->jumlah;
        $selisih_nominal = 0;

        if ((int)$nominal_awal >= (int)$nominal) {
            $selisih_nominal = (int)$nominal_awal - (int)$nominal;
            $pengeluaran_awal = $keuangan_sekolah->pengeluaran;
            $transaksi->jumlah = $nominal;
            if(Session::get('tipe_user') == 1){
                $keuangan_sekolah->pengeluaran = (int)$pengeluaran_awal - (int)$selisih_nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$selisih_nominal;
                $transaksi->approved = 1;
            }else{
                $transaksi->approved = 0;
            }
        } else {
            $selisih_nominal = (int)$nominal - (int)$nominal_awal;
            $pengeluaran_awal = $keuangan_sekolah->pengeluaran;
            $transaksi->jumlah = $nominal;
            if(Session::get('tipe_user') == 1){
                $keuangan_sekolah->pengeluaran = (int)$pengeluaran_awal + (int)$selisih_nominal;
                $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$selisih_nominal;
                $transaksi->approved = 1;
            }else{
                $transaksi->approved = 0;
            }
        }

        $transaksi->save();
        $keuangan_sekolah->save();

        return response($transaksi, 200);
    }

    public function deletePengeluaran(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');

        $transaksi = Transaksi::find($id_transaksi);
        $keuangan_sekolah = KeuanganSekolah::first();
        $nominal_awal = $transaksi->jumlah;
        if($transaksi->approved == 1){
            $keuangan_sekolah->pengeluaran -= (int)$nominal_awal;
            $keuangan_sekolah->total += (int)$nominal_awal;
        }
        $transaksi->soft_delete = 1;

        $transaksi->save();
        $keuangan_sekolah->save();

        return response($transaksi, 200);
    }

    public function pemasukan(Request $request)
    {
        $keterangan = $request->input('keterangan');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $transaksi = new Transaksi();
        $transaksi->id_admin = Session::get('id_user');
        $transaksi->nomor_transaksi = '005000' . date('dmY');
        $transaksi->kode_transaksi = 'PMSKN' . date('hi-dmY');
        $transaksi->nama_transaksi = $keterangan;
        $transaksi->tipe_transaksi = 5;
        $transaksi->jumlah = (int)$nominal;

        $keuangan_sekolah = KeuanganSekolah::first();
        if (!$keuangan_sekolah) {
            $keuangan_sekolah = new KeuanganSekolah();
            $keuangan_sekolah->pemasukan = $nominal;
            $keuangan_sekolah->total = $nominal;
        } else {
            $keuangan_sekolah->pemasukan = (int)$keuangan_sekolah->pemasukan + (int)$nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$nominal;
        }

        $transaksi->save();
        $keuangan_sekolah->save();

        return response($keuangan_sekolah, 200);
    }

    public function updatePemasukan(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $nominal = $request->input('nominal');
        $nominal = str_replace('Rp', '', $nominal);
        $nominal = str_replace('.', '', $nominal);
        $nominal = str_replace(' ', '', $nominal);

        $transaksi = Transaksi::find($id_transaksi);
        $keuangan_sekolah = KeuanganSekolah::first();
        $nominal_awal = $transaksi->jumlah;
        $selisih_nominal = 0;

        if ((int)$nominal_awal >= (int)$nominal) {
            $selisih_nominal = (int)$nominal_awal - (int)$nominal;
            $pemasukan_awal = $keuangan_sekolah->pemasukan;
            $transaksi->jumlah = $nominal;
            $keuangan_sekolah->pemasukan = (int)$pemasukan_awal - (int)$selisih_nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total - (int)$selisih_nominal;
        } else {
            $selisih_nominal = (int)$nominal - (int)$nominal_awal;
            $pemasukan_awal = $keuangan_sekolah->pemasukan;
            $transaksi->jumlah = $nominal;
            $keuangan_sekolah->pemasukan = (int)$pemasukan_awal + (int)$selisih_nominal;
            $keuangan_sekolah->total = (int)$keuangan_sekolah->total + (int)$selisih_nominal;
        }

        $transaksi->save();
        $keuangan_sekolah->save();

        return response($transaksi, 200);
    }

    public function deletePemasukan(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');

        $transaksi = Transaksi::find($id_transaksi);
        $keuangan_sekolah = KeuanganSekolah::first();
        $nominal_awal = $transaksi->jumlah;
        $keuangan_sekolah->pemasukan -= (int)$nominal_awal;
        $keuangan_sekolah->total -= (int)$nominal_awal;
        $transaksi->soft_delete = 1;

        $transaksi->save();
        $keuangan_sekolah->save();

        return response($transaksi, 200);
    }

    public function updateKaryawan(Request $request){
        $id_anggota = $request->input('id_anggota');
        $nama_karyawan = $request->input('nama_karyawan') ?? null;
        $nip = $request->input('nip') ?? null;
        $jabatan = $request->input('jabatan') ?? null;
    
        $karyawan = Anggota::find($id_anggota);
        $nama_karyawan != null && $karyawan->nama = $nama_karyawan;
        $nip != null && $karyawan->nip = $nip;
        $karyawan->save();
    
        if($jabatan != null){
          $master_jabatan = StrukturSekolah::find($jabatan);
          $master_jabatan->id_anggota = $karyawan->id_anggota;
          $master_jabatan->save();
        }
    
        return response($karyawan, 200);
    }

    public function deleteKaryawan(Request $request){
        $id_anggota = $request->input('id_anggota');
    
        $karyawan = Anggota::find($id_anggota);
        $karyawan->soft_delete = 1;
        $karyawan->save();

        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)
            ->first();
        $keuangan_anggota->soft_delete = 1;
        $keuangan_anggota->save();
    
        return response($karyawan, 200);
    }

    public function updateSiswa(Request $request){
        $id_anggota = $request->input('id_anggota');
        $nama_siswa = $request->input('nama_siswa') ?? null;
        $nis = $request->input('nis') ?? null;
        $jenis_kelamin = $request->input('jenis_kelamin') ?? null;
        $id_kelas = $request->input('id_kelas') ?? null;
        $id_jurusan = $request->input('id_jurusan') ?? null;
        $nomor_kelas = $request->input('nomor_kelas') ?? null;
        $status_siswa = $request->input('status_siswa') ?? null;
    
        $siswa = Anggota::find($id_anggota);
        $nama_siswa != null && $siswa->nama = $nama_siswa;
        $nis != null && $siswa->nis = $nis;
        $jenis_kelamin != null && $siswa->jenis_kelamin = $jenis_kelamin;
        $id_kelas != null && $siswa->id_kelas = $id_kelas;
        $id_jurusan != null && $siswa->id_jurusan = $id_jurusan;
        $nomor_kelas != null && $siswa->nomor_kelas = $nomor_kelas;
        $status_siswa != null && $siswa->alumni = $status_siswa;
        $siswa->save();
    
        return response($siswa, 200);
    }

    public function deleteSiswa(Request $request){
        $id_anggota = $request->input('id_anggota');
    
        $siswa = Anggota::find($id_anggota);
        $siswa->soft_delete = 1;
        $siswa->save();

        $keuangan_anggota = KeuanganAnggota::where('id_anggota', $id_anggota)
            ->first();
        $keuangan_anggota->soft_delete = 1;
        $keuangan_anggota->save();
    
        return response($siswa, 200);
    }

    public function updateTeller(Request $request){
        $id_user = $request->input('id_user');
        $nama_teller = $request->input('nama_teller') ?? null;
        $username = $request->input('username') ?? null;
        $password = $request->input('password') ?? null;
        $password != null && $password = Hash::make($password);
    
        $teller = User::find($id_user);
        $nama_teller != null && $teller->nama = $nama_teller;
        $username != null && $teller->username = $username;
        $password != null && $teller->password = $password;
        $teller->save();
    
        return response($teller, 200);
    }

    public function deleteTeller(Request $request){
        $id_user = $request->input('id_user');
    
        $teller = User::find($id_user);
        $teller->soft_delete = 1;
        $teller->save();
    
        return response($teller, 200);
    }

    public function updateJabatan(Request $request){
        $id_struktur_sekolah = $request->input('id_struktur_sekolah');
        $jabatan = $request->input('jabatan') ?? null;
    
        $struktur_sekolah = StrukturSekolah::find($id_struktur_sekolah);
        $jabatan != null && $struktur_sekolah->jabatan = $jabatan;
        $struktur_sekolah->save();
    
        return response($struktur_sekolah, 200);
    }

    public function deleteJabatan(Request $request){
        $id_struktur_sekolah = $request->input('id_struktur_sekolah');
    
        $struktur_sekolah = StrukturSekolah::find($id_struktur_sekolah);
        $struktur_sekolah->soft_delete = 1;
        $struktur_sekolah->save();

        return response($struktur_sekolah, 200);
    }

    public function updateJurusan(Request $request){
        $id_jurusan = $request->input('id_jurusan');
        $nama = $request->input('nama') ?? null;
    
        $jurusan = Jurusan::find($id_jurusan);
        $nama != null && $jurusan->nama = $nama;
        $jurusan->save();
    
        return response($jurusan, 200);
    }

    public function deleteJurusan(Request $request){
        $id_jurusan = $request->input('id_jurusan');
    
        $jurusan = Jurusan::find($id_jurusan);
        $jurusan->soft_delete = 1;
        $jurusan->save();

        return response($jurusan, 200);
    }

    public function updateJenisPembayaran(Request $request){
        $id_tagihan = $request->input('id_tagihan');
        $nama = $request->input('nama') ?? null;
        $id_kelas = $request->input('id_kelas') ?? null;
        $jumlah = $request->input('jumlah') ?? null;

        if($jumlah){
            $jumlah = str_replace('Rp', '', $jumlah);
            $jumlah = str_replace('.', '', $jumlah);
            $jumlah = str_replace(' ', '', $jumlah);
        }
    
        $tagihan = Tagihan::find($id_tagihan);
        $nama != null && $tagihan->nama = $nama;
        $id_kelas != null && $tagihan->id_kelas = $id_kelas;
        $jumlah != null && $tagihan->jumlah = $jumlah;
        $tagihan->save();
    
        return response($tagihan, 200);
    }

    public function deleteJenisPembayaran(Request $request){
        $id_tagihan = $request->input('id_tagihan');
    
        $tagihan = Tagihan::find($id_tagihan);
        $tagihan->soft_delete = 1;
        $tagihan->save();

        return response($tagihan, 200);
    }

    public function laporanPembayaranSpp(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $id_kelas = $request->input('id_kelas') ?? null;
        $id_jurusan = $request->input('id_jurusan') ?? null;
        $nomor_kelas = $request->input('nomor_kelas') ?? null;
    
        $laporan = Transaksi::where('tipe_transaksi', 1)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->with('Anggota', 'Anggota.Kelas', 'Anggota.Jurusan', 'Admin')
            ->whereHas('Anggota', function($q) use($id_kelas, $id_jurusan, $nomor_kelas){
                if($id_kelas != null){
                    if($id_kelas == 0){
                        $q->where('alumni', '=', 1);
                    }else{
                        $q->where('id_kelas', $id_kelas);
                    }
                }
                $id_jurusan && $q->where('anggota.id_jurusan', $id_jurusan);
                $nomor_kelas && $q->where('anggota.nomor_kelas', $nomor_kelas);
            })
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return response($laporan, 200);
    }

    public function laporanPembayaranSppKelas(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $id_kelas = $request->input('id_kelas');
        $id_jurusan = $request->input('id_jurusan');
        $nomor_kelas = $request->input('nomor_kelas');

        $anggota = Anggota::where('id_kelas', $id_kelas)
            ->where('id_jurusan', $id_jurusan)
            ->where('nomor_kelas', $nomor_kelas)
            ->where('soft_delete', 0)
            ->with('Kelas', 'Jurusan', 'KeuanganAnggota')
            ->orderBy('nama', 'ASC')
            ->get();

        foreach($anggota as $a){
            $transaksi = Transaksi::where('tipe_transaksi', 1)
                ->whereDate('tanggal', '>=', $tanggal_awal)
                ->whereDate('tanggal', '<=', $tanggal_akhir)
                ->where('id_anggota', $a->id_anggota)
                ->where('soft_delete', 0)
                ->sum('jumlah');

            $a['total_pembayaran'] = $transaksi;
        }

        return response($anggota, 200);
    }

    public function laporanPembayaranTabungan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
    
        $laporan = Transaksi::where('tipe_transaksi', '>=', 2)
            ->where('tipe_transaksi', '<=', 3)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->with('Anggota.Kelas', 'Anggota.Jurusan', 'Anggota.Jabatan', 'Admin')
            ->get();

        return response($laporan, 200);
    }

    public function laporanPengajuanKeringanan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
    
        $laporan = PengajuanKeringanan::whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->orderBy('id_pengajuan_keringanan', 'DESC')
            ->with('Anggota.Kelas', 'Anggota.Jurusan')
            ->get();

        return response($laporan, 200);
    }

    public function laporanPemasukanLain(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
    
        $laporan = Transaksi::where('tipe_transaksi', 5)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->with('Admin')
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return response($laporan, 200);
    }

    public function laporanPenggunaanDana(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
    
        $laporan = Transaksi::where('tipe_transaksi', 4)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->with('Admin')
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        return response($laporan, 200);
    }

    public function laporan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $total_tabungan = Transaksi::where('tipe_transaksi', 2)
            ->where('soft_delete', 0)
            ->sum('jumlah');

        $tarik_tabungan = Transaksi::where('tipe_transaksi', 3)
            ->where('soft_delete', 0)
            ->sum('jumlah');

        $keuangan_sekolah = KeuanganSekolah::first();
        if($keuangan_sekolah){
            $total_keuangan_sekolah = $keuangan_sekolah->total;
        }else{
            $total_keuangan_sekolah = 0;
        }

        $tabungan_sekolah = (int) $total_tabungan - (int) $tarik_tabungan;
        $bpp_sekolah = (int) $total_keuangan_sekolah - (int) $tabungan_sekolah;

        $tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 2)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->sum('jumlah');
        $data_tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 2)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->first();

        $tarik_tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 3)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->sum('jumlah');
        $data_tarik_tabungan_bulan_ini = Transaksi::where('tipe_transaksi', 3)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->first();

        $spp_bulan_ini = Transaksi::where('tipe_transaksi', 1)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->sum('jumlah');
        $data_spp_bulan_ini = Transaksi::where('tipe_transaksi', 1)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->first();

        $transaksi_lain_bulan_ini = Transaksi::where('tipe_transaksi', '>=', 4)
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->where('soft_delete', 0)
            ->orderBy('id_transaksi', 'DESC')
            ->get();

        $data['bpp_sekolah'] = $bpp_sekolah;
        $data['tabungan_sekolah'] = $tabungan_sekolah;
        $data['tabungan_bulan_ini'] = $tabungan_bulan_ini;
        $data['tarik_tabungan_bulan_ini'] = $tarik_tabungan_bulan_ini;
        $data['spp_bulan_ini'] = $spp_bulan_ini;
        $data['transaksi_lain_bulan_ini'] = $transaksi_lain_bulan_ini;
        $data['data_tabungan_bulan_ini'] = $data_tabungan_bulan_ini;
        $data['data_tarik_tabungan_bulan_ini'] = $data_tarik_tabungan_bulan_ini;
        $data['data_spp_bulan_ini'] = $data_spp_bulan_ini;

        return response($data, 200);
    }

    public function changePassword(Request $request){
        $update_password_lama = $request->input('update_password_lama');
        $update_password = $request->input('update_password');
    
        $user = User::find(Session::get('id_user'));
        $password = Hash::check($update_password_lama, $user->password);
        if($password){
            $new_password = Hash::make($update_password);
            $user->password = $new_password;
            $user->save();
            
            return response($user, 200);
        }else{
            return response(null, 406);
        }
    }

    public function resetTahunAjar(Request $request){
        $kelas = Kelas::where('soft_delete', 0)
            ->orderBy('id_kelas', 'DESC')
            ->get();

        foreach($kelas as $k){
            $id_kelas = $k->id_kelas;
            $jenis_pembayaran = $request->input('jenis_pembayaran'.$id_kelas);
            $nominal = $request->input('nominal'.$id_kelas);
            $nominal = str_replace('Rp', '', $nominal);
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(' ', '', $nominal);

            $tagihan_siswa = Tagihan::where('id_kelas', $id_kelas)
                ->where('soft_delete', 0)
                ->first();
            $tagihan_siswa->nama = $jenis_pembayaran;
            $tagihan_siswa->jumlah = $nominal;
            $tagihan_siswa->save();

            $naik_kelas = (int)$id_kelas + 1;
            if($id_kelas < 3){
                $anggota = Anggota::where('tipe_anggota', 2)
                    ->where('id_kelas', $id_kelas)
                    ->where('alumni', 0)
                    ->get();

                $jumlah_tagihan = $request->input('nominal'.$naik_kelas);
                $jumlah_tagihan = str_replace('Rp', '', $jumlah_tagihan);
                $jumlah_tagihan = str_replace('.', '', $jumlah_tagihan);
                $jumlah_tagihan = str_replace(' ', '', $jumlah_tagihan);

                foreach($anggota as $a){
                    $a->id_kelas = $naik_kelas;
                    $keuangan_anggota = KeuanganAnggota::where('id_anggota', $a->id_anggota)
                        ->first();

                    if($keuangan_anggota){
                        $tagihan_lama = (int)$keuangan_anggota->tagihan;
                        $keuangan_anggota->tagihan = (int)$tagihan_lama + (int)$jumlah_tagihan;
                        $keuangan_anggota->save();
                    }
                    $a->save();
                }
            }else if($id_kelas == 3){
                $anggota = Anggota::where('tipe_anggota', 2)
                    ->where('id_kelas', $id_kelas)
                    ->where('alumni', 0)
                    ->update([
                        'alumni' => 1,
                    ]);
            }

        }
    
        return response('success', 200);
    }
}
