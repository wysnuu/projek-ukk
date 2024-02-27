<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Ukuran;
use App\Models\TransaksiDetail;
use Illuminate\Database\Eloquent\Model;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KasirTransaksiController extends Controller
{
    public function dibayarkan(Request $request, $id)
{
    $request->validate([
        'dibayarkan' => 'required|numeric',
    ]);

    $transaksi = Transaksi::findOrFail($id);
    $totalBelanja = $transaksi->total;
    $dibayarkan = $request->input('dibayarkan');
    $kembalian = $dibayarkan - $totalBelanja;

    // Check if payment is sufficient
    if ($dibayarkan >= $totalBelanja) {
        // Payment is sufficient, so update the transaction and set success to true
        $transaksi->dibayarkan = $dibayarkan;
        $transaksi->kembalian = $kembalian;
        $transaksi->save();

        return response()->json([
            'success' => true,
            'kembalian' => $kembalian,
        ]);
    } else {
        // Payment is insufficient, so return error response
        return response()->json([
            'success' => false,
            'message' => 'Insufficient payment. Please enter more.'
        ]);
    }
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua transaksi
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
    
        // Loop melalui transaksi dan hapus yang memiliki status "pending"
        foreach ($transaksi as $transaksiItem) {
            if ($transaksiItem->status == 'Pending') {
                $transaksiItem->delete();
            }
        }
    
        // Ambil kembali transaksi setelah penghapusan
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
    
        $data = [
            'transaksi' => $transaksi,
            'content' => 'kasir/transaksi/index'
        ];
    
        return view('kasir.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'user_id' => auth()->user()->id,
            'kasir_name' => auth()->user()->name,
            'total' => 0,
            'dibayarkan' => 0,
            'kembalian' => 0,
        ];
        $transaksi = Transaksi::create($data);
        return redirect('/kasir/transaksi/' . $transaksi->id . '/edit');
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
        $transaksi_detail = TransaksiDetail::whereTransaksiId($id)->get();

        $data = [
            'transaksi' => Transaksi::find($id),
            'transaksi_detail' => $transaksi_detail,
            'content' => 'kasir.transaksi.show'
        ];
        return view('kasir.layouts.wrapper', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::get();
        $ukuran = Ukuran::get();

        $produk_id = request('produk_id');
        $p_detail = Produk::find($produk_id);

        $transaksi_detail = TransaksiDetail::whereTransaksiId($id)->get();

        $act = request('act');
        $qty = request('qty');
        if ($act == 'min'){
            if($qty <= 1){
                $qty = 1;
            } else {
                $qty = $qty - 1;
            }
        } else {
            $qty = $qty + 1;
        }

        $subtotal = 0;
        if ($p_detail) {
            $subtotal = $qty * $p_detail->harga;
        }

        $transaksi = Transaksi::find($id);

        $dibayarkan = request('dibayarkan');
        $kembalian = $dibayarkan - $transaksi->total;

        $data = [
            'produk' => $produk,
            'p_detail' => $p_detail,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'transaksi_detail' => $transaksi_detail,
            'transaksi' => $transaksi,
            'kembalian' => $kembalian,
            'ukuran' => $ukuran,
            'content' => 'kasir.transaksi.create'
        ];
        return view('kasir.layouts.wrapper', $data);
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
        $transaksi = Transaksi::find($id);
        $transaksi->delete();
        Alert::success('Sukses', 'Data telah dihapus');
        return redirect('/kasir/transaksi')->with('success', 'Data telah dihapus');
    }

    public function print($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi_detail = TransaksiDetail::where('transaksi_id', $id)->get();
        $pdf = Pdf::loadView('/kasir/transaksi/print', compact('transaksi', 'transaksi_detail'));
        return $pdf->stream();
    }
}
