<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use GuzzleHttp\Promise\Create;

class AdminKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'kategori' => Kategori::all(),
            'content' => 'admin.kategori.index'
        ];
        return view ('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'content' => 'admin.kategori.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:kategoris'
        ]);
        Kategori::create($data);
        Alert::success('Sukses', 'Data telah ditambahkan');
        return redirect('/admin/kategori')->with('success', 'Data telah ditambahkan');
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
            'kategori' => Kategori::find($id),
            'content' => 'admin.kategori.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);
        $data = $request->validate([
            'name' => 'required|unique:kategoris,name,' . $kategori->id
        ]);
        $kategori->update($data);
        Alert::success('Sukses', 'Data telah diubah');
        return redirect('/admin/kategori')->with('success', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        Alert::success('Sukses', 'Data telah dihapus');
        return redirect('/admin/kategori')->with('success', 'Data telah dihapus');
    }
}
