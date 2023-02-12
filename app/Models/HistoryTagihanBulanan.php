<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTagihanBulanan extends Model
{
    protected $table = 'history_tagihan_bulanan';
    protected $primaryKey = 'id_history_tagihan';
    protected $fillable = ['id_history_tagihan','id_anggota','id_tagihan','kelas','bulan','jumlah','status','soft_delete'];

    public function Anggota()
    {
        return $this->hasOne('App\Models\Anggota','id_anggota','id_anggota');
    }

    public function Tagihan()
    {
        return $this->hasOne('App\Models\Tagihan','id_tagihan','id_tagihan');
    }
}
