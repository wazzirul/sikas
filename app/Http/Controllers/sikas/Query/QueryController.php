<?php

namespace App\Http\Controllers\sikas\Query;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Anggota;

class QueryController extends Controller
{
    public function dataSiswa(Request $request){
        $search = $request->input('search');
        $anggota = Anggota::where('nama', 'LIKE', '%'.$search.'%')
            ->orWhere('nisn', 'LIKE', '%'.$search.'%')
            ->where('tipe_anggota', 2)
            ->where('soft_delete', 0)
            ->inRandomOrder()
            ->limit(3)
            ->with('Kelas', 'Jurusan')
            ->get();

        return response($anggota, 200);
    }

    public function siswaById(Request $request){
        $id = $request->input('id');
        $anggota = Anggota::where('id_anggota', $id)
            ->with('Kelas', 'Jurusan', 'KeuanganAnggota')
            ->get();

        return response($anggota, 200);
    }
}
