<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/fontawesome-free-5.15.3-web/css/all.css">
    <link rel="stylesheet" href="/css/spur.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="/css/font.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap-imageupload.css">
    <script src="/js/Chart.bundle.min.js"></script>
    <script src="/js/chart-js-config.js"></script>
    <style>
        .dataTables_filter {
            display: none;
        }
        #text{
            display: none;
        }
    </style>
    <title>
        {{-- @if(Route::is('main') )
            IAC | Sistem Keuangan
        @elseif(Route::is('dataakun') )
            IAC | Data Akun
        @elseif(Route::is('datakas') )
            IAC | Data Buku Kas
        @elseif(Route::is('datakat') )
            IAC | Data Kategori
        @elseif(Route::is('jurnal') )
            IAC | Jurnal Umum
        @else
            IAC | Sistem Keuangan
        @endif  --}}
        IAC | Sistem Keuangan
</title>
</head>

<body>
    <div class="dash">
        <div class="dash-nav dash-nav-dark">
            <header>
                <a href="#!" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </a>
                <a href="/main" class="spur-logo">
                    <img class="mr-2" width="40px" height="40px" src="/img/alpin.png" alt="">
                    <span>IAC</span>
                </a>
            </header>
            <nav class="dash-nav-list" id="sidebar">
                <a href="/main" class="dash-nav-item">
                    <i class="fas fa-tachometer-alt"></i> Dashboard </a>
                <a href="/main/akun" class="dash-nav-item">
                    <i class="far fa-plus-square"></i>Tambah Akun</a>
                <a href="/main/kas" class="dash-nav-item">
                    <i class="far fa-plus-square"></i>Tambah Buku Kas</a>
                <a href="/main/kategori" class="dash-nav-item">
                    <i class="far fa-plus-square"></i>Tambah Kategori</a>
                <div class="dash-nav-dropdown">
                    <a href="#!" class="dash-nav-item dash-nav-dropdown-toggle">
                        <i class="fas fa-donate"></i> Keuangan </a>
                    <div class="dash-nav-dropdown-menu">
                        <a href="/main/keuangan/addin" class="dash-nav-dropdown-item">Tambah Debit</a>
                        <a href="/main/keuangan/addout" class="dash-nav-dropdown-item">Tambah Kredit</a>
                        <a href="/main/keuangan" class="dash-nav-dropdown-item">Rekap</a>
                    </div>
                </div>
                <div class="dash-nav-dropdown">
                    <a href="#!" class="dash-nav-item dash-nav-dropdown-toggle">
                        <i class="fas fa-file"></i> Laporan </a>
                    <div class="dash-nav-dropdown-menu">
                        <a href="/main/jurnal" class="dash-nav-dropdown-item"><i class="far fa-file-alt mr-2"></i>Jurnal Umum</a>
                        <a href="/main/laporan-specific" class="dash-nav-dropdown-item"><i class="far fa-file-alt mr-2"></i>Per Akun</a>
                    </div>
                </div>
                <div class="dash-nav-dropdown">
                    <a href="#!" class="dash-nav-item dash-nav-dropdown-toggle">
                        <i class="fas fa-cog"></i> Lainnya </a>
                    <div class="dash-nav-dropdown-menu">
                        <a href="/main/reset-data" class="dash-nav-dropdown-item"><i class="fas fa-sync mr-2"></i> Reset Data </a>
                        <a href="blank.html" class="dash-nav-dropdown-item"><i class="fas fa-user-alt mr-2"></i> Akun </a>
                        <a href="content.html" class="dash-nav-dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i> Logout </a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="dash-app">
            <header class="dash-toolbar">
                <a href="#!" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </a>
                <p class="pt-3" title="" id="greeting"></p>
                <p class="ml-1 pt-3">Hi</p>
                {{-- <div class="tools">
                    <div class="clock">
                        <button type="submit" class="btn" id="time" disabled></button>
                    </div>
                </div> --}}
                <div class="tools mr-lg-4">
                    <a class="tools-item">
                        <div class="clock mr-4">
                            <button type="submit" class="btn" id="time" disabled></button>
                        </div>
                    </a>
                    <a class="tools-item ml-2 tools-control">
                        <img src="/img/default.png" alt="..." width="30" height="30" class="rounded-circle border border-white">
                    </a>
                </div>
            </header>
            <div class="container mb-3">
                {{-- Content --}}
                <!-- Bagian Judul -->
                <br>
                    <h4 class="container">@yield('judul_halaman')</h4>
                    <h5 style="margin-left: 36px">@yield('tanggal')</h5>
			    <!-- Bagian Konten -->
			    @yield('konten')
            </div>
        </div>
    <script src="/js/popper.min.js"></script>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/jquery.dataTables.min.js"></script>
	<script src="/js/dataTables.bootstrap5.min.js"></script>  
    <script src="/js/dataTables.buttons.min.js"></script>
    <script src="/js/buttons.bootstrap5.min.js"></script>
    <script src="/js/jszip.min.js"></script>
    <script src="/js/pdfmake.min.js"></script>
    <script src="/js/vfs_fonts.js"></script>
    <script src="/js/buttons.html5.min.js"></script>
    <script src="/js/buttons.print.min.js"></script>
    <script src="/js/buttons.colVis.min.js"></script>
    <script src="/js/dataTables.responsive.min.js"></script>
	<script src="/js/bootstrap.js"></script>
    <script src="/js/spur.js"></script>
    <script src="/js/bootstrap-imageupload.js"></script>
    <script>
        var span = document.getElementById('time');
        function time() {
            var d = new Date();
            var s = d.getSeconds();
            var m = d.getMinutes();
            var h = d.getHours();
            span.textContent = 
                ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
        }
        setInterval(time, 1000);
    </script> 
    <script>
        var myDate = new Date();
        var currentHour = myDate.getHours();
        var msg;
        if (currentHour <= 11)
            msg = 'Good morning, ';
        else if(currentHour == 12)
            msg = 'Good noon, ';
        else if (currentHour >= 12 && currentHour <= 17)
            msg = 'Good afternoon, ';
        else if (currentHour >= 18 && currentHour <= 19)
            msg = 'Good evening, ';
        else if (currentHour >= 20)
            msg = 'Good night, ';

        document.getElementById('greeting').innerHTML = msg;
    </script>
</body>

</html>