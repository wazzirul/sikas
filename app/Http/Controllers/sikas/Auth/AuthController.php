<?php

namespace App\Http\Controllers\sikas\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;

class AuthController extends Controller
{
    public function authenticate(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)
            ->first();

        if($user){
            if($user->soft_delete === 1){
                return redirect()->back()->with("error", "Data akun telah dihapus.");
            }

            $password = Hash::check($request->password, $user->password);
            if($password){
                Session::put('authenticated', true);
                Session::put('id_user', $user->id_user);
                Session::put('nama', $user->nama);
                Session::put('tipe_user', $user->tipe_user);

                return redirect('/')->with("success", "Login berhasil.");
            }else{
                return redirect()->back()->with("error", "Password salah.");
            }

        }else{
            return redirect()->back()->with("error", "Data akun tidak ditemukan.");
        }
    }

    public function logout(){
        Session::flush();
        return redirect('/login');
    }

    public function newAdmin(){
        $username = 'admin';
        $password = 'admin';
        $password = Hash::make($password);

        $data = new User();
        $data->tipe_user = 1;
        $data->nama = $username;
        $data->username = $username;
        $data->password = $password;
        $data->save();

        return view('sikas.login');
    }
}
