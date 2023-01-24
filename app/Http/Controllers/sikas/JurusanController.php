<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jurusan;

class JurusanController extends Controller
{
  public function index(){
    $jurusan = Jurusan::where('soft_delete', 0)
      ->orderBy('id_jurusan', 'DESC')
      ->get();

    return view('sikas.master-jurusan', [
      'jurusan' => $jurusan,
    ]);
  }

  public function postJurusan(Request $request){
    $nama = $request->input('jurusan');

    $jurusan = Jurusan::where('nama', $nama)
      ->first();

    if($jurusan){
      $jurusan->soft_delete = '0';
      $jurusan->save();
    }else{
      $jurusan = new Jurusan();
      $jurusan->nama = $nama;
      $jurusan->save();
    }

    return redirect('/master-jurusan');
  }
}
