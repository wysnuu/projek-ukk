<div class="container-fluid pt-2">
    <div class="row p-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>QTY</th>
                            <th>Subtotal</th>
                        </tr>

                        @foreach ($transaksi_detail as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->produk_name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ 'Rp. '.format_rupiah($item->subtotal) }}</td>
                        </tr>
                        @endforeach
                    </table>
                    <a href="/admin/transaksi" class="btn btn-primary btn-block">Kembali</a>
                </div>
            </div>
        </div>

    </div>

    <div class="row p-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="formDibayarkan" method="GET">
                        @csrf
                        <!-- Input for total belanja -->
                        <div class="form-group">
                            <label for="total_belanja">Total Belanja</label>
                            <div class="input-group">
                                <!-- Disabled input field for displaying total belanja -->
                                <input type="number" value="{{ $transaksi->total }}" name="total_belanja" class="form-control" disabled>
                            </div>
                        </div>
                        <!-- Input for dibayarkan -->
                        <div class="form-group">
                            <label for="dibayarkan">Uang Pembayaran</label>
                            <div class="input-group">
                                <div class="input-group-prepend mt-2">
                                    <span class="input-group-text white-bg">Rp</span>
                                </div>
                                <input type="number" name="dibayarkan" id="dibayarkan" value="{{ $transaksi->dibayarkan }}" class="form-control mt-2" disabled>
                            </div>
                        </div>
                    </form>

                    <div class="form-group">
                        <label for="kembalian">Uang Kembalian</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text white-bg">Rp</span>
                            </div>
                            <input type="text" value="{{ $transaksi->kembalian }}" class="form-control" id="kembalian" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>