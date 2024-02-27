<?php

namespace App\Http\Controllers;

use App\Models\Ukuran;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUkuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'ukuran' => Ukuran::get(),
            'content' => 'admin.ukuran.index'
        ];
        return view ('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'content' => 'admin.ukuran.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'size' => 'required',
        ]);
        Ukuran::create($data);
        Alert::success('Sukses', 'Data telah ditambahkan');
        return redirect('/admin/ukuran')->with('success', 'Data telah ditambahkan');
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
            'ukuran' => Ukuran::find($id),
            'content' => 'admin.ukuran.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ukuran = Ukuran::find($id);
        $data = $request->validate([
            'size' => 'required',
        ]);
        $ukuran->update($data);
        Alert::success('Sukses', 'Data telah diubah');
        return redirect('/admin/ukuran')->with('success', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ukuran = Ukuran::find($id);
        $ukuran->delete();
        Alert::success('Sukses', 'Data telah dihapus');
        return redirect('/admin/ukuran')->with('success', 'Data telah dihapus');
    }
}
