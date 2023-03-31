<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BridgeHistoryBulan extends Model
{
    protected $table = 'bridge_history_bulan';
    protected $primaryKey = 'id_bridge_history_bulan';
    protected $fillable = ['id_bridge_history_bulan','id_transaksi','id_history_tagihan','soft_delete'];

}
