<?php

namespace App\Imports;

use Session;
use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\Jurusan;
use App\Models\HistoryTagihanBulanan;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportBPP implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if($row[2] && $row[3]){
            if($row[1] == "" || $row[1] == "0") $row[1] = "-"; 
            $siswa = Anggota::where('nama', $row[2])
                ->where('nis', $row[1])
                ->first();

            $getKelas = explode("-", $row[3]);

            $kelas = Kelas::where('nama', $getKelas[0])
                ->first();

            $jurusan = Jurusan::where('nama', $getKelas[1])
                ->first();

            $nomor_kelas = $getKelas[2];
    
            if($siswa){
                $siswa->jenis_kelamin = $row[4];
                $siswa->tipe_anggota = 2;
                $siswa->nomor_kelas = $nomor_kelas;
                $siswa->soft_delete = '0';
            }else{
                $siswa = new Anggota();
                $siswa->jenis_kelamin = $row[4];
                $siswa->tipe_anggota = 2;
                $siswa->nama = $row[2];
                $siswa->nis = $row[1];
                $siswa->nomor_kelas = $nomor_kelas;
            }

            if($row[5] == 'Aktif'){
                $siswa->alumni = 0;
            }else if($row[5] == 'Alumni'){
                $siswa->alumni = 1;
                $siswa->angkatan = $row[7];
            }else{
                $siswa->alumni = 2;
            }

            if($kelas){
                $siswa->id_kelas = $kelas->id_kelas;
            }

            if($jurusan){
                $siswa->id_jurusan = $jurusan->id_jurusan;
            }else{
                $new_jurusan = new Jurusan();
                $new_jurusan->nama = $getKelas[1];
                $new_jurusan->save();

                $siswa->id_jurusan = $new_jurusan->id_jurusan;
            }
            $siswa->save();

            if($row[5] == 'Alumni'){
                $nama_tagihan = 'SPP';
                $tagihan = Tagihan::where('nama', $nama_tagihan)
                    ->where('tipe_tagihan', 1)
                    ->where('angkatan', $siswa->angkatan)
                    ->first();

                if(!$tagihan){
                    $nama_tagihan = 'BPP';
                    $tagihan = Tagihan::where('nama', $nama_tagihan)
                        ->where('tipe_tagihan', 1)
                        ->where('angkatan', $siswa->angkatan)
                        ->first();
                }

                if(!$tagihan){
                    $nominal_partisipasi = $row[22];
                    $nominal_bayar = $row[23];

                    $nominal_partisipasi = str_replace('Rp', '', $nominal_partisipasi);
                    $nominal_partisipasi = str_replace('rp', '', $nominal_partisipasi);
                    $nominal_partisipasi = str_replace('.', '', $nominal_partisipasi);
                    $nominal_partisipasi = str_replace(' ', '', $nominal_partisipasi);

                    $nominal_bayar = str_replace('Rp', '', $nominal_bayar);
                    $nominal_bayar = str_replace('rp', '', $nominal_bayar);
                    $nominal_bayar = str_replace('.', '', $nominal_bayar);
                    $nominal_bayar = str_replace(' ', '', $nominal_bayar);

                    $pembayaran_total = (int)$nominal_partisipasi + (int)$nominal_bayar;

                    $tagihan = new Tagihan();
                    $tagihan->nama = $nama_tagihan;
                    $tagihan->tipe_tagihan = 1;
                    $tagihan->id_kelas = 3;
                    $tagihan->angkatan = $siswa->angkatan;
                    $tagihan->jumlah = $pembayaran_total;
                    $tagihan->status = 2;

                    if($row[6] == "Angsuran") $tagihan->flow_tagihan = 1;
                    else $tagihan->flow_tagihan = 2;

                    $tagihan->save();
                }
            }else{
                $tagihan = Tagihan::where('id_kelas', $kelas->id_kelas)
                    ->where('tipe_tagihan', 1)
                    ->first();
            }
            
    
            $id_anggota = $siswa->id_anggota;
            $keuangan_siswa = KeuanganAnggota::where('id_anggota', $id_anggota)
                ->first();

            if($keuangan_siswa){
                $keuangan_siswa->soft_delete = '0';
            }else{
                $keuangan_siswa = new KeuanganAnggota();
                $keuangan_siswa->id_anggota = $id_anggota;
            }

            $keuangan_siswa->tagihan = $tagihan->jumlah;
            $keuangan_siswa->tagihan_pertama = $tagihan->jumlah;
            $keuangan_siswa->angsuran_ke = 0;
            $keuangan_siswa->tipe_tagihan = $tagihan->flow_tagihan;

            if($tagihan->flow_tagihan == 2){
                $bulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari',
                   'Maret', 'April', 'Mei', 'Juni'];
          
                $total_tagihan_bulanan = round((int)$tagihan->jumlah / 12);
          
                foreach($bulan as $b){
                    $history_bulanan = HistoryTagihanBulanan::where('id_anggota', $siswa->id_anggota)
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
                    
                    $history_bulanan->bulan = $b;
                    $history_bulanan->jumlah = $total_tagihan_bulanan;
                    $history_bulanan->status = 0;
                    $history_bulanan->save();
                }
            }

            $keuangan_siswa->save();

            $keuangan_sekolah = KeuanganSekolah::first();
            if($row[6] == "Angsuran"){
                $nominal_partisipasi = $row[23];
                $nominal_bayar = $row[24];

                $nominal_partisipasi = str_replace('Rp', '', $nominal_partisipasi);
                $nominal_partisipasi = str_replace('rp', '', $nominal_partisipasi);
                $nominal_partisipasi = str_replace('.', '', $nominal_partisipasi);
                $nominal_partisipasi = str_replace(' ', '', $nominal_partisipasi);

                $nominal_bayar = str_replace('Rp', '', $nominal_bayar);
                $nominal_bayar = str_replace('rp', '', $nominal_bayar);
                $nominal_bayar = str_replace('.', '', $nominal_bayar);
                $nominal_bayar = str_replace(' ', '', $nominal_bayar);

                if($nominal_partisipasi == '-' || $nominal_partisipasi == '') $nominal_partisipasi = 0;
                if($nominal_bayar == '-' || $nominal_bayar == '') $nominal_bayar = 0;

                $pembayaran_total = (int)$nominal_partisipasi + (int)$nominal_bayar;
                $keuangan_siswa->tagihan = (int)$nominal_partisipasi;
                $keuangan_siswa->tagihan_pertama = (int)$pembayaran_total;

                $keuangan_sekolah->pemasukan += (int)$nominal_partisipasi;
                $keuangan_sekolah->total += (int)$nominal_partisipasi;

                $index_bulan = 11;
                $index_terbayar = 0;
                for ($q = 0; $q < 12; $q++) {
                    if($row[$index_bulan] != ""){
                        $pembayaran_bulanan = $row[$index_bulan];

                        $pembayaran_bulanan = str_replace('Rp', '', $pembayaran_bulanan);
                        $pembayaran_bulanan = str_replace('rp', '', $pembayaran_bulanan);
                        $pembayaran_bulanan = str_replace('.', '', $pembayaran_bulanan);
                        $pembayaran_bulanan = str_replace(' ', '', $pembayaran_bulanan);

                        $pembayaran_bulanan = (int)$pembayaran_bulanan;
                        if(is_string($pembayaran_bulanan)) $pembayaran_bulanan = 0;

                        if($pembayaran_bulanan != 0){
                            $index_terbayar++;

                            $transaksi_baru = new Transaksi();
                            $transaksi_baru->id_admin = Session::get('id_user');
                            $transaksi_baru->nomor_transaksi = '001000' . date('dmY');
                            $transaksi_baru->kode_transaksi = 'AKDMK-' . $id_anggota . '-' . date('hi-dmY');
                            $transaksi_baru->nama_transaksi = $tagihan->nama.' Angsuran ke-'.$index_terbayar;
                            $transaksi_baru->id_anggota = $id_anggota;
                            $transaksi_baru->tipe_transaksi = 1;
                            $transaksi_baru->jumlah = $pembayaran_bulanan;
                            $transaksi_baru->kelas = $kelas->nama;
                            $transaksi_baru->save();
                        }
                    }

                    $index_bulan++;
                }

                $keuangan_siswa->angsuran_ke = (int)$index_terbayar;

            }else if($row[6] == "Bulanan"){
                $nominal_partisipasi = $row[23];
                $nominal_bayar = $row[24];

                $nominal_partisipasi = str_replace('Rp', '', $nominal_partisipasi);
                $nominal_partisipasi = str_replace('rp', '', $nominal_partisipasi);
                $nominal_partisipasi = str_replace('.', '', $nominal_partisipasi);
                $nominal_partisipasi = str_replace(' ', '', $nominal_partisipasi);

                $nominal_bayar = str_replace('Rp', '', $nominal_bayar);
                $nominal_bayar = str_replace('rp', '', $nominal_bayar);
                $nominal_bayar = str_replace('.', '', $nominal_bayar);
                $nominal_bayar = str_replace(' ', '', $nominal_bayar);

                if($nominal_partisipasi == '-' || $nominal_partisipasi == '') $nominal_partisipasi = 0;
                if($nominal_bayar == '-' || $nominal_bayar == '') $nominal_bayar = 0;

                $pembayaran_total = (int)$nominal_partisipasi + (int)$nominal_bayar;
                $keuangan_siswa->tagihan = (int)$nominal_partisipasi;
                $keuangan_siswa->tagihan_pertama = (int)$pembayaran_total;

                $history_bulanan = HistoryTagihanBulanan::where('id_anggota', $siswa->id_anggota)
                    ->where('id_tagihan', $tagihan->id_tagihan)
                    ->orderBy('id_history_tagihan', 'DESC')
                    ->limit(12)
                    ->get();

                $index_bulan = 11;
                $tahun_bayar = date('Y');
                if($row[5] == "Alumni"){
                    $tahun_angkatan = explode("-", $row[7]);
                    $tahun_bayar = $tahun_angkatan[0];
                }

                $terbayar = false;
                $index_terbayar = 0;
                $total_bayar_bulanan = 0;
                foreach ($history_bulanan->reverse() as $key => $value) {
                    if($row[$index_bulan] != ""){
                        $pembayaran_bulanan = $row[$index_bulan];

                        $pembayaran_bulanan = str_replace('Rp', '', $pembayaran_bulanan);
                        $pembayaran_bulanan = str_replace('rp', '', $pembayaran_bulanan);
                        $pembayaran_bulanan = str_replace('.', '', $pembayaran_bulanan);
                        $pembayaran_bulanan = str_replace(' ', '', $pembayaran_bulanan);

                        $pembayaran_bulanan = (int)$pembayaran_bulanan;
                        if(is_string($pembayaran_bulanan)) $pembayaran_bulanan = 0;

                        if($pembayaran_bulanan != 0){
                            $transaksi_baru = new Transaksi();
                            $transaksi_baru->id_admin = Session::get('id_user');
                            $transaksi_baru->nomor_transaksi = '001000' . date('dmY');
                            $transaksi_baru->kode_transaksi = 'AKDMK-' . $value->id_anggota . '-' . date('hi-dmY');
                            $transaksi_baru->nama_transaksi = $tagihan->nama.' '.$value->bulan;
                            $transaksi_baru->id_anggota = $value->id_anggota;
                            $transaksi_baru->tipe_transaksi = 1;
                            $transaksi_baru->jumlah = $pembayaran_bulanan;
                            $transaksi_baru->kelas = $kelas->nama;
                            $transaksi_baru->save();

                            $total_bayar_bulanan += $pembayaran_bulanan;
                        }

                        $terbayar = true;
                        $index_terbayar = $index_bulan;
                    }

                    $index_bulan += 1;
                }

                $index_bulan = 11;
                foreach ($history_bulanan->reverse() as $key => $value) {
                    if($total_bayar_bulanan > 0){
                        $total_bayar_bulanan -= $value->jumlah;

                        if($total_bayar_bulanan >= 0){
                            $value->status = 1;
                            $value->save();
                        }
                    }
                    $index_bulan += 1;
                }
            }

            if($row[8] != null){
                $tagihan_pertama = $row[8];
                $tagihan_pertama = str_replace('Rp', '', $tagihan_pertama);
                $tagihan_pertama = str_replace('rp', '', $tagihan_pertama);
                $tagihan_pertama = str_replace('.', '', $tagihan_pertama);
                $tagihan_pertama = str_replace(' ', '', $tagihan_pertama);
                $keuangan_siswa->tagihan_pertama = (int)$tagihan_pertama;
            }

            $keuangan_siswa->save();
            $keuangan_sekolah->save();

            return $siswa;
        }
    }
}
