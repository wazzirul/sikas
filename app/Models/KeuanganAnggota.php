<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganAnggota extends Model
{
    protected $table = 'keuangan_anggota';
    protected $primaryKey = 'id_keuangan_anggota';
    protected $fillable = ['id_keuangan_anggota','id_anggota','tabungan','tagihan','status_tagihan','soft_delete'];
}
