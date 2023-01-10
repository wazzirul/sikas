<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\StrukturSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportKaryawan implements ToModel, WithStartRow
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
        if($row[0] && $row[1]){
            $karyawan = Anggota::where('nama', $row[1])
                ->where('nip', $row[0])
                ->first();
    
            if($karyawan){
                $karyawan->soft_delete = '0';
                $karyawan->save();
            }else{
                $karyawan = new Anggota();
                $karyawan->tipe_anggota = 1;
                $karyawan->nama = $row[1];
                $karyawan->nip = $row[0];
                $karyawan->save();
            }
    
            $id_anggota = $karyawan->id_anggota;
            $keuangan_karyawan = KeuanganAnggota::where('id_anggota', $id_anggota)
                ->first();
            if($keuangan_karyawan){
                $keuangan_karyawan->soft_delete = '0';
                $keuangan_karyawan->save();
            }else{
                $keuangan_karyawan = new KeuanganAnggota();
                $keuangan_karyawan->id_anggota = $id_anggota;
                $keuangan_karyawan->save();
            }
    
            if($row[2] != ""){
                $master_jabatan = StrukturSekolah::where('jabatan', $row[2])
                    ->first();

                if($master_jabatan){
                    $master_jabatan->id_anggota = $id_anggota;
                    $master_jabatan->save();
                }
            }
            return $karyawan;
        }
    }
}
