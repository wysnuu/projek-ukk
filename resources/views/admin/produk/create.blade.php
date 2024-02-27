<div class="container-fluid pt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h4><b>Tambah Data</b></h4>
                    @isset($produk)
                    <form action="/admin/produk/{{$produk->id}}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @else
                        <form action="/admin/produk" method="POST" enctype="multipart/form-data">
                            @endisset
                            @csrf
                            <div class="form-group">
                                <label for=""><b>Kode Produk</b></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="Kode Produk" value="{{isset ($produk) ? $produk->kode : old('kode')}}">
                                @error('kode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Nama Produk</b></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama Produk" value="{{isset ($produk) ? $produk->name : old('name')}}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Nama Kategori</b></label>
                                <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" id="">
                                    <option value="">Kategori</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" {{ isset($produk) ? $item->id == $produk->kategori_id ? 'selected' : '' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Ukuran</b></label>
                                <select name="ukuran_id" class="form-control @error('ukuran_id') is-invalid @enderror" id="">
                                    <option value="">Ukuran</option>
                                    @foreach ($ukuran as $item)
                                    <option value="{{ $item->id }}" {{ isset($produk) ? $item->id == $produk->ukuran_id ? 'selected' : '' : '' }}>{{ $item->size }}</option>
                                    @endforeach
                                </select>
                                @error('ukuran_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Harga</b></label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" placeholder="Harga" value="{{isset ($produk) ? $produk->harga : old('harga')}}">
                                @error('harga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Diskon</b></label>
                                <input type="number" class="form-control @error('diskon') is-invalid @enderror" name="diskon" placeholder="Diskon" value="{{isset ($produk) ? $produk->diskon : old('diskon')}}">
                                @error('diskon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Stok</b></label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" placeholder="Stok" value="{{isset ($produk) ? $produk->stok : old('stok')}}">
                                @error('stok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <a href="/admin/produk" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('form').addEventListener('submit', function(event) {
            const stokInput = document.querySelector('input[name="stok"]');
            if (parseInt(stokInput.value) < 0) {
                alert('Stok tidak boleh negatif');
                event.preventDefault(); // Mencegah pengiriman form jika stok negatif
            }
        });
    });
</script>