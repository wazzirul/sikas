<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    protected $fillable = ['id_tagihan','nama','jumlah','id_kelas','angkatan','status','tipe_tagihan',
        'flow_tagihan','soft_delete'];

    public function Kelas()
    {
        return $this->hasOne('App\Models\Kelas','id_kelas','id_kelas');
    }
}
