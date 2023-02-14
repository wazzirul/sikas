<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\KeuanganAnggota;
use App\Models\Tagihan;
use App\Models\HistoryTagihanBulanan;
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
        if($row[1] && $row[2]){
            $siswa = Anggota::where('nama', $row[2])
                ->where('nis', $row[1])
                ->first();

            $getKelas = explode("-", $row[4]);

            $kelas = Kelas::where('nama', $getKelas[0])
                ->first();

            $jurusan = Jurusan::where('nama', $getKelas[1])
                ->first();

            $nomor_kelas = $getKelas[2];
    
            if($siswa){
                $siswa->jenis_kelamin = $row[3];
                $siswa->tipe_anggota = 2;
                $siswa->nomor_kelas = $nomor_kelas;
                $siswa->soft_delete = '0';
            }else{
                $siswa = new Anggota();
                $siswa->jenis_kelamin = $row[3];
                $siswa->tipe_anggota = 2;
                $siswa->nama = $row[2];
                $siswa->nis = $row[1];
                $siswa->nomor_kelas = $nomor_kelas;
            }

            if($row[5] == 'Aktif'){
                $siswa->alumni = 0;
            }else if($row[5] == 'Alumni'){
                $siswa->alumni = 1;
                $siswa->angkatan = $row[6];
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

            $tagihan = Tagihan::where('id_kelas', $kelas->id_kelas)
                ->where('tipe_tagihan', 1)
                ->first();
    
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
    
            return $siswa;
        }
    }
}
