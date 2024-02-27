<div class="container-fluid pt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h4><b>Tambah Data</b></h4>
                    @isset($ukuran)
                    <form action="/admin/ukuran/{{$ukuran->id}}" method="POST">
                        @method('put')
                        @else
                        <form action="/admin/ukuran" method="POST">
                            @endisset
                            @csrf
                            <div class="form-group">
                                <label for=""><b>Ukuran</b></label>
                                <input type="text" class="form-control @error('size') is-invalid @enderror" name="size" placeholder="Ukuran" value="{{isset ($ukuran) ? $ukuran->size : old('size')}}">
                                @error('size')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <a href="/admin/ukuran" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>