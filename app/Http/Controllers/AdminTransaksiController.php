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

class AdminTransaksiController extends Controller
{
    public function dibayarkan(Request $request, $id)
    {
        $request->validate([
            'dibayarkan' => 'required|numeric',
        ]);

        $transaksi = Transaksi::findOrfail($id);
        $totalBelanja = $transaksi->total;
        $dibayarkan = $request->input('dibayarkan');
        $kembalian = $dibayarkan - $totalBelanja;

        // Simpan nilai kembalian ke dalam entri kembalian
        $transaksi->dibayarkan = $dibayarkan;
        $transaksi->kembalian = $kembalian;
        $transaksi->save();

        return response()->json([
            'success' => true,
            'kembalian' => $kembalian,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Transaksi::orderBy('created_at', 'DESC');

        // Jika tanggal mulai dan akhir disertakan, tambahkan kondisi whereBetween
        if ($start_date && $end_date) {
            // Tambahkan waktu selesai pada akhir tanggal untuk mencakup seluruh hari yang dipilih
            $end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }
    
        $data = [
            'title' => 'Transaksi',
            'subTitle' => 'Atur Transaksi dengan Lebih Mudah',
            'transaksi' => $query->get(), // Ganti Model dengan model yang sesuai
            'transaksi_detail' => TransaksiDetail::get(),
            'content' => 'admin/transaksi/index'
        ];
    
        return view('admin.layouts.wrapper', $data);
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
        return redirect('/admin/transaksi/' . $transaksi->id . '/edit');
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
            'content' => 'admin.transaksi.show'
        ];
        return view('admin.layouts.wrapper', $data);
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
            'content' => 'admin.transaksi.create'
        ];
        return view('admin.layouts.wrapper', $data);
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
        return redirect('/admin/transaksi')->with('success', 'Data telah dihapus');
    }

    public function print($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi_detail = TransaksiDetail::where('transaksi_id', $id)->get();
        $pdf = Pdf::loadView('/admin/transaksi/print', compact('transaksi', 'transaksi_detail'));
        return $pdf->stream();
    }

    public function all($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi_detail = TransaksiDetail::where('transaksi_id', $id)->get();
        $pdf = Pdf::loadView('/admin/transaksi/print/all', compact('transaksi', 'transaksi_detail'));
        return $pdf->stream();
    }

    public function filter(Request $request)
{
    $tanggal_awal = $request->tanggal_awal;
    $tanggal_akhir = $request->tanggal_akhir;

    // Ambil semua transaksi yang sesuai dengan rentang tanggal yang dipilih
    $transaksi = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
                            ->whereDate('created_at', '<=', $tanggal_akhir)
                            ->get();

    // Ambil transaksi detail untuk setiap transaksi yang ditemukan
    $transaksi_detail = [];
    foreach ($transaksi as $t) {
        $transaksi_detail[$t->id] = TransaksiDetail::where('transaksi_id', $t->id)->get();
    }

    $data = [
        'transaksi' => $transaksi,
        'transaksi_detail' => $transaksi_detail, // Sertakan transaksi detail dalam data yang dikirimkan ke tampilan
        'content' => 'admin.transaksi.index'
    ];
    return view('admin.layouts.wrapper', $data);
}

}
