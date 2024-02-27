<div class="container-fluid pt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h4><b>Tambah Data</b></h4>
                    @isset($kategori)
                    <form action="/admin/kategori/{{$kategori->id}}" method="POST">
                        @method('put')
                        @else
                        <form action="/admin/kategori" method="POST">
                            @endisset
                            @csrf
                            <div class="form-group">
                                <label for=""><b>Nama Kategori</b></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama Kategori" value="{{isset ($kategori) ? $kategori->name : old('name')}}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <a href="/admin/kategori" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>