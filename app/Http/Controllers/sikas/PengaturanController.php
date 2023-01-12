<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    //
  public function index(){
    return view('sikas.pengaturan');
  }

  public function resetTahunAjar(){
    return view('sikas.reset-tahun-ajar');
  }
}
