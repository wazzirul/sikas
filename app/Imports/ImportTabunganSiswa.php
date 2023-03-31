<?php

namespace App\Imports;

use Session;
use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\Transaksi;
use App\Models\Kelas;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportTabunganSiswa implements ToModel, WithStartRow
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
        if($row[2] && $row[3] && $row[7]){
            if($row[1] == "" || $row[1] == "0") $row[1] = "-"; 
            $anggota = Anggota::where('nama', $row[2])
                ->where('nis', $row[1])
                ->first();

            $getKelas = explode("-", $row[3]);

            $kelas = Kelas::where('nama', $getKelas[0])
                ->first();

            $jurusan = Jurusan::where('nama', $getKelas[1])
                ->first();

            $nomor_kelas = $getKelas[2];
    
            if($anggota){
                $anggota->jenis_kelamin = $row[4];
                $anggota->tipe_anggota = 2;
                $anggota->nomor_kelas = $nomor_kelas;
                $anggota->soft_delete = '0';
            }else{
                $anggota = new Anggota();
                $anggota->jenis_kelamin = $row[4];
                $anggota->tipe_anggota = 2;
                $anggota->nama = $row[2];
                $anggota->nis = $row[1];
                $anggota->nomor_kelas = $nomor_kelas;
            }

            if($row[5] == 'Aktif'){
                $anggota->alumni = 0;
            }else if($row[5] == 'Alumni'){
                $anggota->alumni = 1;
                $anggota->angkatan = $row[6];
            }else{
                $anggota->alumni = 2;
            }

            if($kelas){
                $anggota->id_kelas = $kelas->id_kelas;
            }

            if($jurusan){
                $anggota->id_jurusan = $jurusan->id_jurusan;
            }else{
                $new_jurusan = new Jurusan();
                $new_jurusan->nama = $getKelas[1];
                $new_jurusan->save();

                $anggota->id_jurusan = $new_jurusan->id_jurusan;
            }
            $anggota->save();

            $keuangan_sekolah = KeuanganSekolah::first();
            $keuangan_anggota = KeuanganAnggota::where('id_anggota', $anggota->id_anggota)
                ->first();

            if($keuangan_anggota){
                $keuangan_anggota->soft_delete = '0';
            }else{
                $keuangan_anggota = new KeuanganAnggota();
                $keuangan_anggota->id_anggota = $anggota->id_anggota;
            }

            $tabungan_lama = (int)$keuangan_anggota->tabungan;
            $tabungan_baru = $row[7];
            $tabungan_baru = str_replace('Rp', '', $tabungan_baru);
            $tabungan_baru = str_replace('rp', '', $tabungan_baru);
            $tabungan_baru = str_replace('.', '', $tabungan_baru);
            $tabungan_baru = str_replace(' ', '', $tabungan_baru);
            $tabungan_baru = (int)$tabungan_baru;

            $keuangan_anggota->tabungan = $tabungan_baru;

            if($tabungan_lama > $tabungan_baru){
                $keuangan_sekolah->pemasukan -= ($tabungan_lama - $tabungan_baru);
                $keuangan_sekolah->total -= ($tabungan_lama - $tabungan_baru);
            }else {
                $keuangan_sekolah->pemasukan += ($tabungan_baru - $tabungan_lama);
                $keuangan_sekolah->total += ($tabungan_baru - $tabungan_lama);
            }

            $transaksi = Transaksi::where('nomor_transaksi', '002000' . date('dmY'))
                ->where('nama_transaksi', 'Setoran Tabungan')
                ->where('tipe_transaksi', 2)
                ->where('id_anggota', $anggota->id_anggota)
                ->first();

            if(!$transaksi){
                $transaksi = new Transaksi();
                $transaksi->id_admin = Session::get('id_user');
                $transaksi->nomor_transaksi = '002000' . date('dmY');
                $transaksi->nama_transaksi = 'Setoran Tabungan';
                $transaksi->id_anggota = $anggota->id_anggota;
                $transaksi->tipe_transaksi = 2;
            }else{
                $transaksi->soft_delete = 0;
            }

            $transaksi->kode_transaksi = 'TBNGN-' . $anggota->id_anggota . '-' . date('hi-dmY');
            $transaksi->jumlah = (int)$tabungan_baru;
            $transaksi->mutasi = (int)$tabungan_baru;

            $keuangan_anggota->save();
            $keuangan_sekolah->save();
            $transaksi->save();

            return $anggota;
        }
    }
}
