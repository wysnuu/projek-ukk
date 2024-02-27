<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminTransaksiDetailController extends Controller
{
    public function create(Request $request)
    {
        $produk_id = $request->produk_id;
        $transaksi_id = $request->transaksi_id;

        // Update stock
        $produk = Produk::find($produk_id);
        $newStock = $produk->stok - $request->qty;
        $produk->update(['stok' => $newStock]);

        $td = TransaksiDetail::whereProdukId($produk_id)->whereTransaksiId($transaksi_id)->first();

        $transaksi = Transaksi::find($transaksi_id);

        // Menghitung diskon dalam persentase
        $diskonPersen = $produk->diskon;
        if ($td == null) {
            // Perhitungan diskon saat pertama kali ditambahkan
            $subtotal = ($request->subtotal - ($request->subtotal * $diskonPersen / 100));
            $data = [
                'produk_id'    => $produk_id,
                'produk_name'  => $request->produk_name,
                'transaksi_id' => $transaksi_id,
                'qty'          => $request->qty,
                'subtotal'     => $subtotal,
            ];


            TransaksiDetail::create($data);
            $dt = [
                'total' => $subtotal + $transaksi->total,
            ];
            $transaksi->update($dt);
        } else {
            // Perhitungan diskon saat tambahan barang
            $subtotal = ($request->subtotal - ($request->subtotal * $diskonPersen / 100));
            $data = [
                'qty'      => $td->qty + $request->qty,
                'subtotal' => $td->subtotal + $subtotal,
            ];
            $td->update($data);
            $dt = [
                'total' => $transaksi->total + $subtotal,
            ];
            $transaksi->update($dt);
        }

        return redirect('/admin/transaksi/' . $transaksi_id . '/edit');
    }

    public function delete()
    {
        $id = request('id');
        $td = TransaksiDetail::find($id);

        $transaksi = Transaksi::find($td->transaksi_id);

        $produk = Produk::find($td->produk_id);
        $newStock = $produk->stok + $td->qty;
        $produk->update(['stok' => $newStock]);

        $data = [
            'total' => $transaksi->total - $td->subtotal,
        ];
        $transaksi->update($data);

        $td->delete();
        return redirect()->back();
    }

    public function done($id)
    {
        $transaksi =  Transaksi::find($id);
        $data = [
            'status' => 'Selesai'
        ];
        $transaksi->update($data);
        Alert::success('Sukses', 'Data telah ditambahkan');
        return redirect('/admin/transaksi')->with(['berhasil' => $id, 'success' => 'Data telah ditambahkan']);
    }

    public function pending($id)
    {
        $transaksi =  Transaksi::find($id);
        $data = [
            'status' => 'Pending'
        ];
        $transaksi->update($data);
        Alert::info('Info', 'Data masih dipending');
        return redirect('/admin/transaksi')->with('info', 'Data telah dipending');
    }
}
