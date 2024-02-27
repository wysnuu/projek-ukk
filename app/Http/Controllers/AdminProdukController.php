<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use GuzzleHttp\Promise\Create;

class AdminProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'produk' => Produk::get(),
            'content' => 'admin.produk.index'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'kategori' => Kategori::get(),
            'ukuran' => Ukuran::get(),
            'content' => 'admin.produk.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required',
            'name' => 'required',
            'kategori_id' => 'required',
            'ukuran_id' => 'required',
            'harga' => 'required',
            'diskon' => 'required|min:0',
            'stok' => 'required|min:0',
        ]);
        Produk::create($data);
        Alert::success('Sukses', 'Data telah ditambahkan');
        return redirect('/admin/produk')->with('success', 'Data telah ditambahkan');
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
            'produk' => Produk::find($id),
            'kategori' => Kategori::get(),
            'ukuran' => Ukuran::get(),
            'content' => 'admin.produk.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::find($id);
        $data = $request->validate([
            'kode' => 'required',
            'name' => 'required',
            'kategori_id' => 'required',
            'ukuran_id' => 'required',
            'harga' => 'required',
            'diskon' => 'required|min:0',
            'stok' => 'required|min:0',
        ]);
        $produk->update($data);
        Alert::success('Sukses', 'Data telah diubah');
        return redirect('/admin/produk')->with('success', 'Data telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        Alert::success('Sukses', 'Data telah dihapus');
        return redirect('/admin/produk')->with('success', 'Data telah dihapus');
    }
}
