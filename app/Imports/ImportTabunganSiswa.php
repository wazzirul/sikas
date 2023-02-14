<?php

namespace App\Imports;

use Session;
use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\Transaksi;
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
        if($row[1] && $row[2] && $row[3] && $row[7]){
            $anggota = Anggota::where('nis', $row[1])
                ->where('nama', $row[2])
                ->where('tipe_anggota', 2)
                ->where('soft_delete', 0)
                ->first();

            if($anggota){
                $keuangan_sekolah = KeuanganSekolah::first();
                $keuangan_anggota = KeuanganAnggota::where('id_anggota', $anggota->id_anggota)
                    ->first();

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

                $transaksi = new Transaksi();
                $transaksi->id_admin = Session::get('id_user');
                $transaksi->nomor_transaksi = '002000' . date('dmY');
                $transaksi->kode_transaksi = 'TBNGN-' . $anggota->id_anggota . '-' . date('hi-dmY');
                $transaksi->nama_transaksi = 'Setoran Tabungan';
                $transaksi->id_anggota = $anggota->id_anggota;
                $transaksi->tipe_transaksi = 2;
                $transaksi->jumlah = (int)$tabungan_baru;
                $transaksi->mutasi = (int)$tabungan_baru;

                $keuangan_anggota->save();
                $keuangan_sekolah->save();
                $transaksi->save();

                return $anggota;
            }
        }
    }
}
