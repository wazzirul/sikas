<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Anggota;

class Main extends Controller
{
    //
  public function index(){
    return view('sikas.dashboard');
  }

  //Login
  public function login(){
    if(Session::has('authenticated')) return redirect('/');
    return view('sikas.login');
  }
  //Register
  public function register(){
    return view('sikas.register');
  }
}
