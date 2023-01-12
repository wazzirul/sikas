<?php

namespace App\Http\Controllers\sikas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StrukturSekolah;

class JabatanController extends Controller
{
    
    public function index(){
        $jabatan = StrukturSekolah::where('soft_delete', 0)
            ->get();

        return view('sikas.master-jabatan', [
            'jabatan' => $jabatan,
        ]);
    }

    public function postJabatan(Request $request){
        $jabatan = $request->input('jabatan');
    
        $struktur_sekolah = StrukturSekolah::where('jabatan', $jabatan)
          ->first();
    
        if($struktur_sekolah){
          $struktur_sekolah->soft_delete = '0';
          $struktur_sekolah->save();
        }else{
          $struktur_sekolah = new StrukturSekolah();
          $struktur_sekolah->jabatan = $jabatan;
          $struktur_sekolah->save();
        }
    
        return redirect('/master-jabatan');
      }
}
