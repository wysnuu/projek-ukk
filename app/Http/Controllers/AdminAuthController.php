<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAuthController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function register()
    {
        $user = User::all();
        return view('admin.auth.register', compact('user'));
    }

    public function doRegister(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'level' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            're_password' => 'required|same:password|min:8',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        Alert::success('Sukses', 'Data telah ditambahkan');
        return redirect('/login')->with('success', 'Data telah ditambahkan');
    }

    public function doLogin(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();

            if($user->level == 'Admin'){
                Alert::success('Sukses', 'Selamat Datang di Aplikasi Kasir');
                return redirect('/admin/dashboard');
            }else {
                Alert::success('Sukses', 'Selamat Datang di Aplikasi Kasir');
                return redirect('/kasir/transaksi');
            }
        }
        else {
            return back()->with('loginError', 'Email atau Password salah');
        }
    }

    public function store(Request $request)
    {
        $data= $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'level' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            're_password' => 'required|same:password|min:8',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        Alert::success('Sukses', 'Data berhasil ditambahkan!!');
        return redirect('/admin/user')->with('success', 'Data berhasil ditambahkan!!');
        
    }

    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
