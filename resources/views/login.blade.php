<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | IAC Finance</title>
    <link rel="stylesheet" type="text/css" href="/fontawesome-free-6.2.0-web/css/all.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/util.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="shortcut icon" href="/assets/image/fav.jpg">
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
				<form class="login100-form validate-form" action="postlogin" method="post">
                    @csrf
					<span class="login100-form-title p-b-40">
						Login
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
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <small><span class="fas fa-exclamation-triangle"></span> {{ Session::get('error') }}</small>
                            </div>
                        @endif
                        @if (Session::has('fail'))
                            <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <small><span class="fas fa-exclamation-triangle"></span> {{ Session::get('fail') }}</small>
                            </div>
                        @endif
                        @if (Session::has('fail2'))
                            <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <small><span class="fas fa-exclamation-triangle"></span> {{ Session::get('fail2') }}</small>
                            </div>
                        @endif
                    <div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username" autocomplete="off" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>
                    <div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="password" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>
                    <div class="d-flex justify-content-end p-t-3 p-b-32">
						<a href="#" data-bs-toggle="modal" data-bs-target="#password" title="Forgot Password" class="txt1">Forgot Password?</a>
                        {{-- <a href="/epass" title="Forgot Password" class="txt1">Forgot Password?</a> --}}
					</div>
                    <div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">Login</button>
					</div>
					<div class="text-center p-t-20 p-b-20">
                        {{-- <p class="txt2">Belum punya akun? <a href="/signup" title="Sign Up" class="txt1">Sign Up</a></a><br> --}}
						<a href="" title="Help" data-bs-toggle="modal" data-bs-target="#help" class="txt2">Help?</a>
					</div>
                    <div class="text-center p-t-40 p-b-20">
                        <p>&copy; 2021 @if($year!=2021)- {{$year}}@endif IAC | All rights reserved</p>
                        <p>Designed by <a href="https://instagram.com/alfien.skm?utm_medium=copy_link" target="_blank">Alfiensukma</a></p>
					</div>
				</form>
				<div class="login100-more" style="background-image: url('assets/export.png');">
                    <div class="box text">
                        <span class="text-1">Selamat Datang di<br> Aplikasi IAC Finance</span>
                        <span class="text-2">Let's make some magic</span>
                    </div>
				</div>
			</div>
		</div>
	</div>

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi Email</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/password" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}   
                        <div class="form-group">
                            <div class="row">
                                <label class="col-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control effect" required="required" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Kirim Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Help-->
    <div class="modal fade" id="help" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-question-circle"></i> Bantuan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item border-0">
                            <h4 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <p>Kembali secara tiba-tiba ke login</p>
                                </button>
                            </h4>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Itu merupakan fitur <strong>session expired</strong>, dimana halaman akan kembali ke login ketika user tidak melakukan aktivitas
                                    selama <strong>2 jam</strong>.
                                </div>
                            </div>
                            <h4 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <p>Error 419 | Page Expired</p>
                                </button>
                            </h4>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Silahkan untuk kembali ke halaman login dan <strong>refresh page</strong> terlebih dahulu sebelum mencoba login kembali.
                                </div>
                            </div>
                            <h4 class="accordion-header" id="heading9">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                    <p>Email yang digunakan untuk regristasi</p>
                                </button>
                            </h4>
                            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Pastikan untuk menggunakan email yang aktif pada saat regristasi, karena pada saat melakukan ubah password link akan
                                    dikirimkan ke email yang Anda gunakan.
                                </div>
                            </div>
                            <h4 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    <p>Lupa Password</p>
                                </button>
                            </h4>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>Pertama</strong>, klik <strong data-bs-toggle="modal" data-bs-target="#password" style="cursor: pointer">Lupa Password?</strong> lalu masukkan email Anda.<br>
                                    <strong>Kedua</strong>, cek email masuk pada email Anda di <strong>kotak masuk</strong> atau <strong>spam</strong>. Jika berada di spam,
                                    maka izinkan email dengan cara <strong>bukan spam</strong> agar link pada email dapat di akses.<br>
                                    <strong>Ketiga</strong>, masukkan password baru dan Konfirmasi password.
                                </div>
                            </div>
                            <h4 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    <p>Verifikasi Email</p>
                                </button>
                            </h4>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Setelah Anda melakukan registrasi, <strong>email verifikasi dikirim ke email.</strong> Anda tidak dapat login ke aplikasi sebelum melakukan
                                    verifikasi email. Batas melakukan verifikasi email adalah <strong>2 jam.</strong>
                                </div>
                            </div>
                        </div>
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
