<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use GuzzleHttp\Promise\Create;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'user' => User::get(),
            'content' => 'admin.user.index'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'content' => 'admin.user.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        return redirect('/admin/user')->with('success', 'Data telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'user' => User::find($id),
            'content' => 'admin.user.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $data = $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'level' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:8',
            're_password' => 'required|same:password|min:8',
        ]);

        // Cek apakah pengguna sedang login dan levelnya akan diubah menjadi 'Kasir'
        if (auth()->check() && $user->id === auth()->id() && $request->level === 'Kasir') {
            Alert::error('Error', 'Anda tidak dapat mengubah level anda menjadi "Kasir" saat sedang login');
            return redirect()->back();
        }

        if ($request->password != '') {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        Alert::success('Sukses', 'Data telah diubah');
        return redirect('/admin/user')->with('success', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user->id == auth()->user()->id) {
            // Jika pengguna yang login mencoba menghapus akunnya sendiri
            Alert::error('Error', 'Anda tidak dapat menghapus pengguna yang sedang digunakan untuk login');
            return redirect('/admin/user')->with('error', 'Anda tidak dapat menghapus pengguna yang sedang digunakan untuk login');
        }
            $user->delete();
            Alert::success('Sukses', 'Data telah dihapus');
            return redirect('/admin/user')->with('success', 'Data telah dihapus');
        }
    }
