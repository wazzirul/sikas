<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\KeuanganAnggota;
use App\Models\Tagihan;
use App\Models\StrukturSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSiswa implements ToModel, WithStartRow
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
            $siswa = Anggota::where('nama', $row[1])
                ->where('nis', $row[0])
                ->first();

            $kelas = Kelas::where('nama', $row[2])
                ->first();

            $jurusan = Jurusan::where('nama', $row[3])
                ->first();
    
            if($siswa){
                $siswa->tipe_anggota = 2;
                $siswa->nomor_kelas = $row[4];
                $siswa->soft_delete = '0';
            }else{
                $siswa = new Anggota();
                $siswa->tipe_anggota = 2;
                $siswa->nama = $row[1];
                $siswa->nis = $row[0];
                $siswa->nomor_kelas = $row[4];
            }

            if($kelas){
                $siswa->id_kelas = $kelas->id_kelas;
            }

            if($jurusan){
                $siswa->id_jurusan = $jurusan->id_jurusan;
            }else{
                $new_jurusan = new Jurusan();
                $new_jurusan->nama = $row[3];
                $new_jurusan->save();

                $siswa->id_jurusan = $new_jurusan->id_jurusan;
            }
            $siswa->save();

            $tagihan = Tagihan::where('id_kelas', $kelas->id_kelas)
                ->first();
    
            $id_anggota = $siswa->id_anggota;
            $keuangan_siswa = KeuanganAnggota::where('id_anggota', $id_anggota)
                ->first();
            if($keuangan_siswa){
                $keuangan_siswa->soft_delete = '0';
                $keuangan_siswa->save();
            }else{
                $keuangan_siswa = new KeuanganAnggota();
                $keuangan_siswa->id_anggota = $id_anggota;
                $keuangan_siswa->tagihan = $tagihan->jumlah;
                $keuangan_siswa->save();
            }
    
            return $siswa;
        }
    }
}
