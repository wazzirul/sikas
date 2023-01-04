<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $fillable = ['id_anggota','tipe_anggota','nama','nisn','nip','id_kelas','id_jurusan','nomor_kelas','soft_delete'];

    public function Kelas()
    {
        return $this->hasOne('App\Models\Kelas','id_kelas','id_kelas');
    }

    public function Jurusan()
    {
        return $this->hasOne('App\Models\Jurusan','id_jurusan','id_jurusan');
    }

    public function KeuanganAnggota()
    {
        return $this->hasOne('App\Models\KeuanganAnggota','id_anggota','id_anggota');
    }
    public function Transaksi()
    {
        return $this->hasOne('App\Models\Transaksi','id_anggota','id_anggota');
    }
    public function Akademik()
    {
        return $this->Transaksi()->where('tipe_transaksi', 1);
    }
}
