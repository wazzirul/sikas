<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Models\User;
use App\Models\Tagihan;

class PengaturanController extends Controller
{
  public function index(){
    $data = User::find(Session::get('id_user'));
    return view('sikas.pengaturan', [
      'data' => $data,
    ]);
  }

  public function resetTahunAjar(){
    $tagihan = Tagihan::with('Kelas')
      ->where('soft_delete', 0)
      ->get();

    return view('sikas.reset-tahun-ajar', [
      'tagihan' => $tagihan,
    ]);
  }
}
