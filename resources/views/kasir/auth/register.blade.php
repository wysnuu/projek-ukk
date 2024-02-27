<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Toko Bersinar</title>
    <link rel="stylesheet" href="/vendor/admin/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/vendor/admin/assets/css/app.css">
</head>

<body>

    <div id="auth">

        <div class="container">
            <div class="row pb-7">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h3 style="font-size: 2.2em; color: cornflowerblue;"><b>Toko Bersinar</b></h3>
                                <p>Isilah form di bawah ini untuk register.</p>
                            </div>
                            <form action="/register/do" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="">Nama User</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama User">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                            <div class="col-md-12 col-12">
                                                <label for="">Level</label>
                                                <select class="form-control @error('level') is-invalid @enderror" name="level" placeholder="Level">
                                                    <option value="">Level</option>
                                                    @if($user->where('level','Admin')->count() == 0)
                                                    <option value="Admin">Admin</option>
                                                    @endif
                                                    @if($user->where('level','Admin')->count() > 0)
                                                    <option value="Kasir">Kasir</option>
                                                    @endif
                                                </select>
                                                @error('level')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <label for="">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <label for="">Password</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <label for="">Konfirmasi Password</label>
                                                <input type="password" class="form-control @error('re_password') is-invalid @enderror" name="re_password" placeholder="Konfirmasi Password">
                                                @error('re_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <button class="btn btn-primary btn-block float-end">Register</button>
                                </div>
                            </form>
                            <div class="divider">
                                <div class="divider-text">Atau</div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <a href="/login"><button class="btn btn-secondary btn-block float-end">Login</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="/vendor/admin/assets/js/feather-icons/feather.min.js"></script>
    <script src="/vendor/admin/assets/js/app.js"></script>

    <script src="/vendor/admin/assets/js/main.js"></script>
</body>

</html>