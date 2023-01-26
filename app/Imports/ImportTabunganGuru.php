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
        if($row[0] && $row[1] && $row[2]){
            $anggota = Anggota::where('nip', $row[0])
                ->where('nama', $row[1])
                ->where('tipe_anggota', 1)
                ->where('soft_delete', 0)
                ->first();

            if($anggota){
                $keuangan_sekolah = KeuanganSekolah::first();
                $keuangan_anggota = KeuanganAnggota::where('id_anggota', $anggota->id_anggota)
                    ->first();

                $tabungan_lama = (int)$keuangan_anggota->tabungan;
                $tabungan_baru = (int)$row[2];

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
