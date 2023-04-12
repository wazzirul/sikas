<?php

namespace App\Imports;

use Session;
use App\Models\KeuanganSekolah;
use App\Models\Transaksi;
use App\Models\TabunganUmum;
use App\Models\StrukturSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportTabunganUmum implements ToModel, WithStartRow
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
            $tabungan_umum = TabunganUmum::where('nama_tabungan', $row[2])
                ->where('keterangan', $row[3])
                ->first();

            if($tabungan_umum){
                $tabungan_umum->soft_delete = 0;
            }else{
                $tabungan_exist = TabunganUmum::where('nomor_tabungan', $row[1])->first();
                if(!$tabungan_exist){
                    $tabungan_umum = new TabunganUmum();
                    $tabungan_umum->nomor_tabungan = $row[1];
                }else{
                    $tabungan_id = TabunganUmum::orderBy('id_tabungan_umum', 'DESC')
                        ->select([
                            'id_tabungan_umum'
                        ])
                        ->first();

                    if($tabungan_id) $id_tabungan = $tabungan_id->id_tabungan_umum + 1;
                    else $id_tabungan = 1;

                    $nomor_tabungan = str_pad($id_tabungan,4,"0",STR_PAD_LEFT);
                    $tabungan_umum = new TabunganUmum();
                    $tabungan_umum->nomor_tabungan = $nomor_tabungan;
                }
            }

            $keuangan_sekolah = KeuanganSekolah::first();
            $tabungan_umum->nama_tabungan = $row[2];
            $tabungan_umum->keterangan = $row[3];
            $tabungan_umum->save();

            $jabatan = StrukturSekolah::where('jabatan', $row['3'])
                ->first();

            if($jabatan){
                $jabatan->soft_delete = 0;
            }else{
                $jabatan = new StrukturSekolah();
                $jabatan->jabatan = $row[3];
            }

            $jabatan->save();
            
            $tabungan_lama = (int)$tabungan_umum->tabungan;
            $tabungan_baru = $row[4];
            $tabungan_baru = str_replace('Rp', '', $tabungan_baru);
            $tabungan_baru = str_replace('rp', '', $tabungan_baru);
            $tabungan_baru = str_replace('.', '', $tabungan_baru);
            $tabungan_baru = str_replace(' ', '', $tabungan_baru);
            $tabungan_baru = str_replace('-', '', $tabungan_baru);
            if($tabungan_baru == "") $tabungan_baru = 0;
            $tabungan_baru = (int)$tabungan_baru;

            $tabungan_umum->tabungan = $tabungan_baru;

            if($tabungan_lama > $tabungan_baru){
                $keuangan_sekolah->pemasukan -= ($tabungan_lama - $tabungan_baru);
                $keuangan_sekolah->total -= ($tabungan_lama - $tabungan_baru);
            }else {
                $keuangan_sekolah->pemasukan += ($tabungan_baru - $tabungan_lama);
                $keuangan_sekolah->total += ($tabungan_baru - $tabungan_lama);
            }

            $id_tabungan_umum = $tabungan_umum->id_tabungan_umum;
            $transaksi = Transaksi::where('nomor_transaksi', '002000' . date('dmY'))
                ->where('nama_transaksi', 'Setoran Tabungan')
                ->where('tipe_transaksi', 2)
                ->where('id_tabungan_umum', $id_tabungan_umum)
                ->first();

            if(!$transaksi){
                $transaksi = new Transaksi();
                $transaksi->id_admin = Session::get('id_user');
                $transaksi->nomor_transaksi = '002000' . date('dmY');
                $transaksi->nama_transaksi = 'Setoran Tabungan';
                $transaksi->id_tabungan_umum = $id_tabungan_umum;
                $transaksi->tipe_transaksi = 2;
            }else{
                $transaksi->soft_delete = 0;
            }

            $transaksi->kode_transaksi = 'TBNGN-UMUM-' . $id_tabungan_umum . '-' . date('hi-dmY');
            $transaksi->jumlah = (int)$tabungan_baru;
            $transaksi->mutasi = (int)$tabungan_baru;

            $tabungan_umum->save();
            $keuangan_sekolah->save();
            $transaksi->save();

            return $tabungan_umum;
        }
    }
}
