<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Toko Bersinar</title>
    <link rel="stylesheet" href="/vendor/admin/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/vendor/admin/assets/css/app.css">
</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row pb-3">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h3 style="font-size: 2.2em; color: cornflowerblue;"><b>Toko Bersinar</b></h3>
                                <p>Silahkan login untuk menuju ke aplikasi.</p>
                            </div>

                            @if(session()->has('loginError'))
                            <div class="alert alert-danger">{{(session('loginError'))}}</div>
                            @endif

                            <form action="/login/do" method="post">
                                @csrf
                                <div class="form-group position-relative has-icon-left">
                                    <label for="email">Email</label>
                                    <div class="position-relative">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email">
                                        <div class="form-control-icon">
                                            <i data-feather="at-sign"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <a href="/forgot-password" class='float-end'>
                                    <small class="mt-4">Lupa Password ?</small>
                                </a>

                                <div class='form-check clearfix my-2'>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" class="btn btn-primary btn-block float-end">Login</button>
                                </div>
                            </form>
                            <div class="divider">
                                <div class="divider-text">Atau</div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <a href="/register"><button class="btn btn-secondary btn-block float-end">Register</button></a>
                                </div>
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