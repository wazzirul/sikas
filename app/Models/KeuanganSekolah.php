<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganSekolah extends Model
{
    protected $table = 'keuangan_sekolah';
    protected $primaryKey = 'id_keuangan_sekolah';
    protected $fillable = ['id_keuangan_sekolah','total','pemasukan','pengeluaran','soft_delete'];
}
