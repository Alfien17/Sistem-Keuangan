<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Update Password | IAC Finance</title>
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
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
            @foreach($user as $u)
                <form action="/postpassword/{{$u->id}}" method="post" class="box">
                    <h1 class="text-center">Update Password</h1>
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
                        <div class="form-floating">
                            <input name="email" value="{{$u->email}}" hidden>
                            <input type="password" class="form-control form-control3 effect-2" id="floatingInput3" placeholder="password" name="password">
                            <label for="floatingInput3">Password Baru</label>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control form-control3 effect-2" id="floatingInput4" placeholder="password" name="password_confirmation">
                            <label for="floatingInput4">Konfirmasi Password</label>
                            <span class="focus-border"></span>
                        </div>
                    </div>
                    <div class="card-footer border-0 mb-4">
                        <button type="submit" class="btn btn-dark btn-block">Update</button>
                    </div>
                </form>
            @endforeach
            </div>
        </div>
    </div>
    <footer class="site-footer">
        <p class="linear-wipe">&copy; 2021 @if($year!=2021)- {{$year}}@endif IAC | All rights reserved</p>
	</footer>
    @include('sweetalert::alert')
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>
