<?php

namespace App\Imports;

use Session;
use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\StrukturSekolah;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportTabunganGuru implements ToModel, WithStartRow
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
        if($row[2] && $row[4]){
            $anggota = Anggota::where('nama', $row[2])
                ->where('tipe_anggota', 1)
                ->first();

            if(!$anggota){
                $anggota = new Anggota();
                $anggota->nip = $row[1];
                $anggota->nama = $row[2];
                $anggota->tipe_anggota = 1;
                $anggota->save();
            }

            if($row[3] && $row[3] != 'Guru'){
                $jabatan = StrukturSekolah::where('jabatan', $row['3'])
                    ->first();

                if($jabatan){
                    $jabatan->soft_delete = 0;
                    $jabatan->id_anggota = $anggota->id_anggota;
                }else{
                    $jabatan = new StrukturSekolah();
                    $jabatan->id_anggota = $anggota->id_anggota;
                    $jabatan->jabatan = $row[3];
                }

                $jabatan->save();
            }

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
            $tabungan_baru = $row[4];
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
                $keuangan_sekolah->pemasukan += ($tabungan_lama - $tabungan_baru);
                $keuangan_sekolah->total += ($tabungan_lama - $tabungan_baru);
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
