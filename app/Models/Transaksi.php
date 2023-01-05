<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['id_transaksi','id_admin','nomor_transaksi','kode_transaksi','id_anggota','tipe_transaksi',
    'nama_transaksi','id_tagihan','jumlah','id_kelas','tanggal','soft_delete'];
}
