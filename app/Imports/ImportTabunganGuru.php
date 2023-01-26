<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
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
        if($row[1] && $row[2] && $row[3]){
            $anggota = Anggota::where('nip', $row[1])
                ->where('nama', $row[2])
                ->where('tipe_anggota', 1)
                ->where('soft_delete', 0)
                ->first();

            if($anggota){
                $keuangan_sekolah = KeuanganSekolah::first();
                $keuangan_anggota = KeuanganAnggota::where('id_anggota', $anggota->id_anggota)
                    ->first();

                $tabungan_lama = (int)$keuangan_anggota->tabungan;
                $tabungan_baru = $row[3];
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

                $keuangan_anggota->save();
                $keuangan_sekolah->save();

                return $anggota;
            }
        }
    }
}
