<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class TellerController extends Controller
{
  public function index(){
    $teller = User::where('tipe_user', 2)
      ->where('soft_delete', 0)
      ->get();

    return view('sikas.teller', [
      'teller' => $teller,
    ]);
  }

  public function postTeller(Request $request){
    $nama_teller = $request->input('nama_teller');
    $username = $request->input('username');
    $password = $request->input('password');
    $password = Hash::make($password);

    $teller = User::where('nama', $nama_teller)
      ->where('username', $username)
      ->first();

    if($teller){
      $teller->soft_delete = '0';
    }else{
      $teller = new User();
      $teller->tipe_user = 2;
      $teller->nama = $nama_teller;
      $teller->username = $username;
      $teller->password = $password;
    }

    $teller->save();

    return redirect('/teller');
  }
}
