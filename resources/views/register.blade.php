<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Register | Sistem Keuangan IAC</title>
        <link rel="stylesheet" href="/fontawesome-free-5.15.3-web/css/all.css">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/style1.css">

        <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="manifest" href="/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

    </head>
<body class="bg-dark2">
    <div class="container">
        <div class="col-md-4 offset-md-4 mt-5">
                <form action="{{ route('register') }}" method="post" class="box">
                    <h1 class="text-center">REGISTRASI</h1>
                    @csrf
                    <div class="card-body">
                        @if (count($errors)>0)
                        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <small>
                                <ul style="list-style:none">
                                    @foreach($errors->all() as $error)
                                    <li><span class="fas fa-exclamation-triangle"></span>
                                    {{$error}}</li>
                                    @endforeach
                                </ul>
                            </small>
                        </div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <small><span class="fas fa-check-circle"></span> {{ Session::get('success') }}</small>
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <small><span class="fas fa-exclamation-triangle"></span> {{ Session::get('error') }}</small>
                            </div>
                        @endif
                        
                        <div class="form-floating">
                            <input type="text" class="form-control form-control2" id="floatingInput" placeholder="email" name="name" autocomplete="off" value="{{old('name')}}">
                            <label for="floatingInput">Nama Lengkap</label>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control form-control2" id="floatingInput2" placeholder="email" name="email" autocomplete="off" value="{{old('email')}}">
                            <label for="floatingInput2">Email</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control form-control2" id="floatingInput3" placeholder="password" name="password">
                            <label for="floatingInput3">Password</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control form-control2" id="floatingInput4" placeholder="password" name="password_confirmation">
                            <label for="floatingInput4">Konfirmasi Password</label>
                        </div>
                    </div>
                    <div class="card-footer border-0">
                        <button type="submit" class="btn btn-dark btn-block">Register</button>
                        <p class="text-center pt-4">Sudah punya akun? <a href="{{ route('login') }}">Login</a> sekarang!</p>
                    </div>
                </form>
        </div>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>
