<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\Kelas;
use App\Models\Jurusan;
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
        if($row[0] && $row[1] && $row[2]){
            $anggota = Anggota::where('nis', $row[0])
                ->where('nama', $row[1])
                ->first();

            if($anggota){
                $anggota->soft_delete = 0;
            }else{
                $anggota = new Anggota();
                $anggota->nis = $row[0];
                $anggota->nama = $row[1];
            }

            $anggota->tipe_anggota = 2;

            $get_kelas = explode("-", $row[2]);
            $kelas = Kelas::where('nama', $get_kelas[0])
                ->first();
            
            $kelas != null ? $id_kelas = $kelas->id_kelas : $id_kelas = 1;
            
            $jurusan = Jurusan::where('nama', $get_kelas[1])
                ->first();

            $jurusan != null ? $id_jurusan = $jurusan->id_jurusan : $id_jurusan = 1;

            $nomor_kelas = $get_kelas[2];

            $anggota->id_kelas = $id_kelas;
            $anggota->id_jurusan = $id_jurusan;
            $anggota->nomor_kelas = $nomor_kelas;
            $anggota->jenis_kelamin = $row[3];

            $status_siswa = strtolower($row[4]);
            if($status_siswa == "aktif"){
                $anggota->alumni = 0;
            }else{
                $anggota->alumni = 1;
            }

            $anggota->save();
            $keuangan_anggota = KeuanganAnggota::where('id_anggota', $anggota->id_anggota)
                ->first();

            if($keuangan_anggota){
                $keuangan_anggota->soft_delete = 0;
                $data_keuangan = 'lama';
                $tagihan_lama = (int)$keuangan_anggota->tagihan;
                $tabungan_lama = (int)$keuangan_anggota->tabungan;
                
            }else{
                $keuangan_anggota = new KeuanganAnggota();
                $data_keuangan = 'baru';
            }

            $keuangan_anggota->id_anggota = $anggota->id_anggota;
            $pembayaran_total = (int)$row[5] + (int)$row[6];
            $keuangan_anggota->tagihan = (int)$row[5];
            $keuangan_anggota->tagihan_pertama = (int)$pembayaran_total;
            $keuangan_anggota->tabungan = (int)$row[7];

            $keuangan_sekolah = KeuanganSekolah::first();
            if($data_keuangan == 'lama'){
                if((int)$tagihan_lama > (int)$row[5]){
                    $keuangan_sekolah->pemasukan -= ((int)$tagihan_lama - (int)$row[5]);
                    $keuangan_sekolah->total -= ((int)$tagihan_lama - (int)$row[5]);
                }else{
                    $keuangan_sekolah->pemasukan += ((int)$row[5] - (int)$tagihan_lama);
                    $keuangan_sekolah->total += ((int)$row[5] - (int)$tagihan_lama);
                }

                if((int)$tabungan_lama > (int)$row[7]){
                    $keuangan_sekolah->pemasukan -= ((int)$tabungan_lama - (int)$row[7]);
                    $keuangan_sekolah->total -= ((int)$tabungan_lama - (int)$row[7]);
                }else{
                    $keuangan_sekolah->pemasukan += ((int)$row[7] - (int)$tabungan_lama);
                    $keuangan_sekolah->total += ((int)$row[7] - (int)$tabungan_lama);
                }
            }else{
                $keuangan_sekolah->pemasukan += (int)$row[5];
                $keuangan_sekolah->total += (int)$row[5];

                $keuangan_sekolah->pemasukan += (int)$row[7];
                $keuangan_sekolah->total += (int)$row[7];
            }

            $keuangan_anggota->save();
            $keuangan_sekolah->save();

            return $anggota;
        }
    }
}
