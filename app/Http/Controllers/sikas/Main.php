<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class Main extends Controller
{
    //
  public function index()
  {
    return view('sikas.dashboard');
  }
  public function login()
  {
    if(Session::has('authenticated')) return redirect('/');
    return view('sikas.login');
  }
  public function register()
  {
    return view('sikas.register');
  }
}
