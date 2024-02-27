<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="/vendor/admin/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/vendor/admin/assets/css/app.css">
</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h3 style="font-size: 2.2em; color: cornflowerblue;"><b>Toko Bersinar</b></h3>
                                <p>Masukkan password baru.</p>
                            </div>
                            <form action="{{ route('password.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="token" value="{{request()->token}}">
                                <input type="hidden" name="email" value="{{request()->email}}">

                                <div class="form-group position-relative has-icon-left">
                                    <label for="password">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group position-relative has-icon-left">
                                    <label for="re_password">Konfirmasi Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" name="re_password" placeholder="Konfirmasi Password">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <input type="submit" value="Ubah password" class="btn btn-primary float-end btn-block">
                                </div>
                            </form>
                            <div class="divider">
                                <div class="divider-text">Atau</div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <a href="/login"><button class="btn btn-secondary btn-block float-end">Anda sudah mulai ingat password anda ?</button></a>
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