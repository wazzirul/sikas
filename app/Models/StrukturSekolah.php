<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturSekolah extends Model
{
    protected $table = 'struktur_sekolah';
    protected $primaryKey = 'id_struktur_sekolah';
    protected $fillable = ['id_struktur_sekolah','id_anggota','jabatan','soft_delete'];
}
