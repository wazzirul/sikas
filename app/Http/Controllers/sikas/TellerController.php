<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TellerController extends Controller
{
    //
  public function index(){
    return view('sikas.teller');
  }
}
