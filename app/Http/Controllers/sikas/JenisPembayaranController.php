<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    //
  public function index(){
    return view('sikas.jenis-pembayaran');
  }
}
