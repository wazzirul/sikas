<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Main extends Controller
{
    //
  public function index()
  {
    return view('sikas.dashboard');
  }
  public function login()
  {
    return view('sikas.login');
  }
  public function register()
  {
    return view('sikas.register');
  }
}
