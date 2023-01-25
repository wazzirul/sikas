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
        if($row[0] && $row[1] && $row[2]){
            $transaksi = new Transaksi();
            $transaksi->id_admin = Session::get('id_user');
            $transaksi->nomor_transaksi = '005000' . date('dmY');
            $transaksi->kode_transaksi = 'PMSKN' . date('hi-dmY');
            $transaksi->nama_transaksi = $row[0];
            $transaksi->tipe_transaksi = 5;
            $transaksi->tanggal = $row[1];
            $transaksi->jumlah = (int)$row[2];

            $keuangan_sekolah = KeuanganSekolah::first();
            $keuangan_sekolah->pemasukan += (int)$row[2];
            $keuangan_sekolah->total += (int)$row[2];

            $transaksi->save();
            $keuangan_sekolah->save();
        }
    }
}
