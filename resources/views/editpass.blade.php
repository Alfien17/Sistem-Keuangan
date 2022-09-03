<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Password | IAC Finance</title>
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
				<form class="login100-form validate-form" action="postepass" method="post">
                    @csrf
					<span class="login100-form-title p-b-30">
						Update Password
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
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="email" autocomplete="off" required>
                            <span class="focus-input100"></span>
                            <span class="label-input100">Email</span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="password" name="password" required>
                            <span class="focus-input100"></span>
                            <span class="label-input100">Password</span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="password" name="password_confirmation" required>
                            <span class="focus-input100"></span>
                            <span class="label-input100">Password Confirmation</span>
                        </div>
                    <div class="container-login100-form-btn pt-4">
						<button class="login100-form-btn" type="submit">Update</button>
					</div>
					<div class="text-center p-t-20 p-b-20">
                        <a class="txt1 text-center pt-4" href="{{ route('login') }}">Login</a>
					</div>
                    <div class="text-center p-t-20 p-b-20">
                        <p>&copy; 2021 @if($year!=2021)- {{$year}}@endif IAC | All rights reserved</p>
                        <p>Designed by <a href="https://instagram.com/alfiensukma?utm_medium=copy_link" target="_blank">Alfiensukma</a></p>
					</div>
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
