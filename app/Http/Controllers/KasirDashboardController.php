<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use Illuminate\Http\Request;

class KasirDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCount = User::count();
        $kategori = Kategori::count();
        $produk = Produk::count();
        $td = TransaksiDetail::count();
        
        return view('dashboard.index', compact('userCount', 'kategori', 'produk', 'td'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
