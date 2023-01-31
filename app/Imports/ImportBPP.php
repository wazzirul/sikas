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
        if($row[2] && $row[3]){
            if($row[1] == "" || $row[1] == "0") $row[1] = "-"; 
            $anggota = Anggota::where('nis', $row[1])
                ->where('nama', $row[2])
                ->first();

            if($anggota){
                $anggota->soft_delete = 0;
            }else{
                $anggota = new Anggota();
                $anggota->nis = $row[1];
                $anggota->nama = $row[2];
            }

            $anggota->tipe_anggota = 2;

            $get_kelas = explode("-", $row[3]);
            $kelas = Kelas::where('nama', $get_kelas[0])
                ->first();
            
            $kelas != null ? $id_kelas = $kelas->id_kelas : $id_kelas = 1;
            
            $jurusan = Jurusan::where('nama', $get_kelas[1])
                ->first();

            if($jurusan){
                $id_jurusan = $jurusan->id_jurusan;
            }else{
                $jurusan = new Jurusan();
                $jurusan->nama = $get_kelas[1];
                $jurusan->save();

                $id_jurusan = $jurusan->id_jurusan;
            }

            $nomor_kelas = $get_kelas[2];

            $anggota->id_kelas = $id_kelas;
            $anggota->id_jurusan = $id_jurusan;
            $anggota->nomor_kelas = $nomor_kelas;

            if($row[4] == "") $row[4] = "-";
            $anggota->jenis_kelamin = $row[4];

            $status_siswa = strtolower($row[5]);
            if($status_siswa == "aktif"){
                $anggota->alumni = 0;
            }elseif($status_siswa == "alumni"){
                $anggota->alumni = 1;
            }else{
                $anggota->alumni = 2;
            }

            $anggota->save();
            $keuangan_anggota = KeuanganAnggota::where('id_anggota', $anggota->id_anggota)
                ->first();

            if($keuangan_anggota){
                $keuangan_anggota->soft_delete = 0;
                $data_keuangan = 'lama';
                $tagihan_lama = (int)$keuangan_anggota->tagihan;
                
            }else{
                $keuangan_anggota = new KeuanganAnggota();
                $data_keuangan = 'baru';
            }

            $keuangan_anggota->id_anggota = $anggota->id_anggota;
            $nominal_partisipasi = $row[6];
            $nominal_bayar = $row[7];

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

            if((int)$nominal_partisipasi < 0) $nominal_partisipasi = 0;
            if((int)$nominal_bayar < 0) $nominal_bayar = 0;

            $pembayaran_total = (int)$nominal_partisipasi + (int)$nominal_bayar;
            $keuangan_anggota->tagihan = (int)$nominal_partisipasi;
            $keuangan_anggota->tagihan_pertama = (int)$pembayaran_total;

            $keuangan_sekolah = KeuanganSekolah::first();
            if($data_keuangan == 'lama'){
                if((int)$tagihan_lama > (int)$nominal_partisipasi){
                    $keuangan_sekolah->pemasukan -= ((int)$tagihan_lama - (int)$nominal_partisipasi);
                    $keuangan_sekolah->total -= ((int)$tagihan_lama - (int)$nominal_partisipasi);
                }else{
                    $keuangan_sekolah->pemasukan += ((int)$nominal_partisipasi - (int)$tagihan_lama);
                    $keuangan_sekolah->total += ((int)$nominal_partisipasi - (int)$tagihan_lama);
                }
            }else{
                $keuangan_sekolah->pemasukan += (int)$nominal_partisipasi;
                $keuangan_sekolah->total += (int)$nominal_partisipasi;
            }

            $keuangan_anggota->save();
            $keuangan_sekolah->save();

            return $anggota;
        }
    }
}
