<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Models\User;

class PengaturanController extends Controller
{
  public function index(){
    $data = User::find(Session::get('id_user'));
    return view('sikas.pengaturan', [
      'data' => $data,
    ]);
  }

  public function resetTahunAjar(){
    return view('sikas.reset-tahun-ajar');
  }
}
