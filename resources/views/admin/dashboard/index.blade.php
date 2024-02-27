<div class="container-fluid pt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <div class="page-title">
                        <h3>Dashboard</h3>
                        <p class="text-subtitle text-muted">Penampilan statistik aplikasi Toko Bersinar.</p>
                    </div>
                    <section class="section">
                        <div class="container-fluid pt-2">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="card shadow-lg p-3 mb-5 bg-primary rounded">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class='px-3 py-3 d-flex justify-content-between'>
                                                    <h3 class='card-title text-white'>Kategori Produk</h3>
                                                    <div class="card-right d-flex align-items-center">
                                                        <p class="text-white">{{$kategori}} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card shadow-lg p-3 mb-5 bg-primary rounded">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class='px-3 py-3 d-flex justify-content-between'>
                                                    <h3 class='card-title text-white'>Jumlah Produk</h3>
                                                    <div class="card-right d-flex align-items-center">
                                                        <p class="text-white">{{$produk}} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card shadow-lg p-3 mb-5 bg-primary rounded">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class='px-3 py-3 d-flex justify-content-between'>
                                                    <h3 class='card-title text-white'>Transaksi Total</h3>
                                                    <div class="card-right d-flex align-items-center">
                                                        <p class="text-white">{{$totalTransaksi}} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card shadow-lg p-3 mb-5 bg-primary rounded">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class='px-3 py-3 d-flex justify-content-between'>
                                                    <h3 class='card-title text-white'>Transaksi Harian</h3>
                                                    <div class="card-right d-flex align-items-center">
                                                        <p class="text-white">{{$td}} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card shadow-lg p-3 mb-5 bg-primary rounded">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class='px-3 py-3 d-flex justify-content-between'>
                                                    <h3 class='card-title text-white'>Pendapatan Harian</h3>
                                                    <div class="card-right d-flex align-items-center">
                                                        <p class="text-white">Rp. {{format_rupiah($totalBiayaPembelian)}} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card shadow-lg p-3 mb-5 bg-primary rounded">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class='px-3 py-3 d-flex justify-content-between'>
                                                    <h3 class='card-title text-white'>Jumlah User</h3>
                                                    <div class="card-right d-flex align-items-center">
                                                        <p class="text-white">{{$userCount}} </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>