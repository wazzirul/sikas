<?php

namespace App\Imports;

use Session;
use App\Models\Transaksi;
use App\Models\KeuanganSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportPemasukan implements ToModel, WithStartRow
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
            $nominal_jumlah = $row[3];
            $nominal_jumlah = str_replace('Rp', '', $nominal_jumlah);
            $nominal_jumlah = str_replace('rp', '', $nominal_jumlah);
            $nominal_jumlah = str_replace('.', '', $nominal_jumlah);
            $nominal_jumlah = str_replace(' ', '', $nominal_jumlah);

            $transaksi = new Transaksi();
            $transaksi->id_admin = Session::get('id_user');
            $transaksi->nomor_transaksi = '005000' . date('dmY');
            $transaksi->kode_transaksi = 'PMSKN' . date('hi-dmY');
            $transaksi->nama_transaksi = $row[1];
            $transaksi->tipe_transaksi = 5;
            $transaksi->tanggal = $row[2];
            $transaksi->jumlah = (int)$nominal_jumlah;

            $keuangan_sekolah = KeuanganSekolah::first();
            if($keuangan_sekolah == null){
                $keuangan_sekolah = new KeuanganSekolah();
                $keuangan_sekolah->save();
            }
            $keuangan_sekolah->pemasukan += (int)$nominal_jumlah;
            $keuangan_sekolah->total += (int)$nominal_jumlah;

            $transaksi->save();
            $keuangan_sekolah->save();
        }
    }
}
