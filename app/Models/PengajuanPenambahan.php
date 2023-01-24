<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPenambahan extends Model
{
    protected $table = 'pengajuan_penambahan';
    protected $primaryKey = 'id_pengajuan_penambahan';
    protected $fillable = ['id_pengajuan_penambahan','id_anggota','jumlah','file','tanggal','soft_delete'];

    public function Anggota()
    {
        return $this->hasOne('App\Models\Anggota','id_anggota','id_anggota');
    }
}
