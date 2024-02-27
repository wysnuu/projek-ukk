<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KasirTransaksiDetailController extends Controller
{
    public function create(Request $request)
{
    $produk_id = $request->produk_id;
    $transaksi_id = $request->transaksi_id;

    // Periksa apakah produk dipilih
    if (!$produk_id) {
        // Jika tidak ada produk yang dipilih, tampilkan SweetAlert dan kembalikan ke halaman sebelumnya
        Alert::error('Error', 'Pilih produk terlebih dahulu')->persistent(true);
        return redirect()->back();
    }

    // Lanjutkan proses tambah detail transaksi jika produk dipilih
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

    return redirect('/kasir/transaksi/' . $transaksi_id . '/edit');
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

    // Periksa apakah transaksi belum dibayarkan
    if (!$transaksi->dibayarkan) {
        // Tampilkan SweetAlert dengan pesan error
        Alert::error('Error', 'Pembayaran belum terlaksana');
        return redirect()->back();
    }

    // Jika pembayaran telah terlaksana, update status transaksi menjadi 'Selesai'
    $data = [
        'status' => 'Selesai'
    ];
    $transaksi->update($data);
    
    // Tampilkan SweetAlert dengan pesan sukses
    Alert::success('Sukses', 'Data telah ditambahkan');
    return redirect('/kasir/transaksi')->with(['berhasil' => $id, 'success' => 'Data telah ditambahkan']);
}

    public function pending($id)
    {
        $transaksi =  Transaksi::find($id);
        $data = [
            'status' => 'Pending'
        ];
        $transaksi->update($data);
        Alert::info('Info', 'Data masih dipending');
        return redirect('/kasir/transaksi')->with('info', 'Data telah dipending');
    }
}
