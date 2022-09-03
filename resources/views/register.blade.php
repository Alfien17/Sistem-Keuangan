<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up | IAC Finance</title>
    <link rel="stylesheet" type="text/css" href="/fontawesome-free-6.2.0-web/css/all.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/util.css">
    <link rel="stylesheet" href="/css/style1.css">
    <link rel="shortcut icon" href="/assets/image/fav.jpg">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
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
<body>
    <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="postsignup" method="post">
                    @csrf
					<span class="login100-form-title">
						Sign Up
					</span>
                        @if (count($errors)>0)
                            <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <small><span class="fas fa-check-circle text-light"></span> {{ Session::get('success') }}</small>
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <small><span class="fas fa-exclamation-triangle text-light"></span> {{ Session::get('error') }}</small>
                            </div>
                        @endif
                        <div class="form-floating">
                            <input type="text" class="form-control form-control3 effect-2" id="floatingInput" placeholder="username" name="username" autocomplete="off" value="{{old('username')}}" required>
                            <label for="floatingInput">Username</label>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control form-control3 effect-2" id="floatingInput1" placeholder="name" name="name" autocomplete="off" value="{{old('name')}}" required>
                            <label for="floatingInput1">Nama Lengkap</label>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control form-control3 effect-2" id="floatingInput2" placeholder="email" name="email" autocomplete="off" value="{{old('email')}}" required>
                            <label for="floatingInput2">Email</label>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control form-control3 effect-2" id="floatingInput3" placeholder="password" name="password" required>
                            <label for="floatingInput3">Password</label>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control form-control3 effect-2" id="floatingInput4" placeholder="password" name="password_confirmation" required>
                            <label for="floatingInput4">Konfirmasi Password</label>
                            <span class="focus-border"></span>
                        </div>
                    <div class="container-login100-form-btn pt-4">
						<button class="login100-form-btn" type="submit">Sign Up</button>
					</div>
					<div class="text-center p-t-20 p-b-20">
                        <p class="txt2 text-center pt-4">Sudah punya akun? <a class="txt1" href="{{ route('login') }}">Login</a> sekarang!</p>
					</div>
                    <p class="d-flex justify-content-center pt-2">&copy; 2021 @if($year!=2021)- {{$year}}@endif IAC | All rights reserved</p>
                    <p>Designed by <a href="https://instagram.com/alfien.skm?utm_medium=copy_link" target="_blank">Alfiensukma</a></p>
				</form>
				<div class="login100-more" style="background-image: url('assets/export.png');">
                    <div class="text">
                        <span class="text-1">Selamat Datang di<br> Aplikasi IAC Finance</span>
                        <span class="text-2">Let's make some magic</span>
                    </div>
				</div>
			</div>
		</div>
	</div>
    @include('sweetalert::alert')

    <script src="/js/popper.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/login/animsition.min.js"></script>
    <script src="/js/login/select2.min.js"></script>
    <script src="/js/login/main.js"></script>
    <script>
        $(window).load(function() {
            $(".form-floating input").val("");
            $(".input-effect input").focusout(function() {
                if($(this).val() != ""){
                    $(this).addClass("has-content");
                }else{
                    $(this).removeClass("has-content");
                }
            });
        });
    </script>  
</body>
</html>
