<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKeringanan extends Model
{
    protected $table = 'pengajuan_keringanan';
    protected $primaryKey = 'id_pengajuan_keringanan';
    protected $fillable = ['id_pengajuan_keringanan','id_anggota','jumlah','file','tanggal','soft_delete'];
}
