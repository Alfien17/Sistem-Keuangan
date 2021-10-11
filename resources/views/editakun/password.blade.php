<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Update Password | Sistem Keuangan IAC</title>
        <link rel="stylesheet" href="/fontawesome-free-5.15.3-web/css/all.css">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/style1.css">
    </head>
<body class="bg-dark">
    <div class="container">
        <div class="col-md-4 offset-md-4 mt-5">
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
                            <input type="password" class="form-control form-control2" id="floatingInput3" placeholder="password" name="password">
                            <label for="floatingInput3">Password</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control form-control2" id="floatingInput4" placeholder="password" name="password_confirmation">
                            <label for="floatingInput4">Konfirmasi Password</label>
                        </div>
                    </div>
                    <div class="card-footer border-0 mb-4">
                        <button type="submit" class="btn btn-dark btn-block">Update</button>
                    </div>
                </form>
            @endforeach
            @include('sweetalert::alert')
        </div>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>
