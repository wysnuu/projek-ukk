<div class="container-fluid pt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h4><b>Tambah Data</b></h4>
                    @isset($user)
                    <form action="/admin/user/{{$user->id}}" method="POST">
                        @method('put')
                        @else
                        <form action="/admin/user" method="POST">
                            @endisset
                            @csrf
                            <div class="form-group">
                                <label for=""><b>Nama User</b></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama User" value="{{isset ($user) ? $user->name : ''}}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Level</b></label>
                                <select class="form-control @error('level') is-invalid @enderror" name="level" placeholder="Level">
                                    <option value="">Level</option>
                                    @if (isset($user) && $user->level == 'Admin')
                                    <option value="Admin" selected>Admin</option>
                                    <option value="Kasir">Kasir</option>
                                    @else 
                                    <option value="Kasir" selected>Kasir</option>
                                    @endif
                                </select>
                                @error('level')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror


                                <label for=""><b>Email</b></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{isset ($user) ? $user->email : ''}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Password</b></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <label for=""><b>Konfirmasi Password</b></label>
                                <input type="password" class="form-control @error('re_password') is-invalid @enderror" name="re_password" placeholder="Konfirmasi Password">
                                @error('re_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <a href="/admin/user" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>