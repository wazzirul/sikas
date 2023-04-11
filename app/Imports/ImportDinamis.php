<?php

namespace App\Imports;

use Session;
use App\Models\Anggota;
use App\Models\KeuanganAnggota;
use App\Models\KeuanganSekolah;
use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\Jurusan;
use App\Models\HistoryTagihanBulanan;
use App\Models\Transaksi;
use App\Models\BridgeHistoryBulan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportDinamis implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }
    
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        if($row[2] && $row[3]){
            if($row[1] == "" || $row[1] == "0") $row[1] = "-"; 
            $anggota = Anggota::where('nama', $row[2])
                ->where('nis', $row[1])
                ->first();

            $getKelas = explode("-", $row[3]);

            $kelas = Kelas::where('nama', $getKelas[0])
                ->first();

            $jurusan = Jurusan::where('nama', $getKelas[1])
                ->first();

            $nomor_kelas = $getKelas[2];
    
            if($anggota){
                $anggota->jenis_kelamin = $row[4];
                $anggota->tipe_anggota = 2;
                $anggota->nomor_kelas = $nomor_kelas;
                $anggota->soft_delete = '0';
            }else{
                $anggota = new Anggota();
                $anggota->jenis_kelamin = $row[4];
                $anggota->tipe_anggota = 2;
                $anggota->nama = $row[2];
                $anggota->nis = $row[1];
                $anggota->nomor_kelas = $nomor_kelas;
            }

            if($row[5] == 'Aktif'){
                $anggota->alumni = 0;
            }else if($row[5] == 'Alumni'){
                $anggota->alumni = 1;
                $anggota->angkatan = $row[7];
            }else{
                $anggota->alumni = 2;
            }

            if($kelas){
                $anggota->id_kelas = $kelas->id_kelas;
            }

            if($jurusan){
                $anggota->id_jurusan = $jurusan->id_jurusan;
            }else{
                $new_jurusan = new Jurusan();
                $new_jurusan->nama = $getKelas[1];
                $new_jurusan->save();

                $anggota->id_jurusan = $new_jurusan->id_jurusan;
            }
            $anggota->save();

            $id_tagihan = $this->id;
            $id_anggota = $anggota->id_anggota;
            $nominal = $row[8];
            $nominal = str_replace('Rp', '', $nominal);
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(' ', '', $nominal);

            $master_tagihan = Tagihan::find($id_tagihan);

            $history_tagihan = HistoryTagihanBulanan::where('id_anggota', $id_anggota)
                ->where('id_tagihan', $id_tagihan)
                ->where('status', 0)
                ->first();

            if(!$history_tagihan){
                $history_tagihan = new HistoryTagihanBulanan();
                $history_tagihan->id_anggota = $id_anggota;
                $history_tagihan->id_tagihan = $master_tagihan->id_tagihan;
                $history_tagihan->prefix_tagihan = $master_tagihan->prefix_tagihan;
                $history_tagihan->jumlah = $master_tagihan->jumlah;
                $history_tagihan->save();
            }

            $nominal_akhir = $row[9];
            $nominal_akhir = str_replace('Rp', '', $nominal_akhir);
            $nominal_akhir = str_replace('.', '', $nominal_akhir);
            $nominal_akhir = str_replace(' ', '', $nominal_akhir);

            Transaksi::where('id_tagihan', $id_tagihan)
                ->where('id_anggota', $id_anggota)
                ->where('tipe_transaksi', 8)
                ->where('soft_delete', 0)
                ->update([
                    'soft_delete' => 1
                ]);

            $kurang_bayar = $master_tagihan->jumlah - ($nominal);
            if($kurang_bayar > $nominal_akhir){
                $transaksi_lalu = $kurang_bayar - $nominal_akhir;

                $transaksi = new Transaksi();
                $transaksi->id_admin = Session::get('id_user');
                $transaksi->nomor_transaksi = '008000' . date('dmY');
                $transaksi->kode_transaksi = 'DNMS-' . $id_anggota . '-' . date('hi-dmY');
                $transaksi->id_anggota = $id_anggota;
                $transaksi->tipe_transaksi = 8;
                $transaksi->id_tagihan = $master_tagihan->prefix_tagihan;
                $transaksi->jumlah = $transaksi_lalu;
                $transaksi->nama_transaksi = $master_tagihan->nama;
                $transaksi->save();
            }

            $transaksi = new Transaksi();
            $transaksi->id_admin = Session::get('id_user');
            $transaksi->nomor_transaksi = '008000' . date('dmY');
            $transaksi->kode_transaksi = 'DNMS-' . $id_anggota . '-' . date('hi-dmY');
            $transaksi->id_anggota = $id_anggota;
            $transaksi->tipe_transaksi = 8;
            $transaksi->id_tagihan = $master_tagihan->prefix_tagihan;
            $transaksi->jumlah = $nominal;
            $transaksi->nama_transaksi = $master_tagihan->nama;
            $transaksi->save();

            return $anggota;
        }
    }
}
