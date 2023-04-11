<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabunganUmum extends Model
{
    protected $table = 'tabungan_umum';
    protected $primaryKey = 'id_tabungan_umum';
    protected $fillable = ['id_tabungan_umum','nama_tabungan','tabungan','keterangan','soft_delete'];

}
