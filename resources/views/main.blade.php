<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/fontawesome-free-5.15.3-web/css/all.css">
    <link rel="stylesheet" href="/css/spur.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
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
                        <a href="/main/editakun/{{Auth::user()->id ??''}}" class="dash-nav-dropdown-item"><i class="fas fa-user-alt mr-2"></i> Akun </a>
                        <a href="/main/help" class="dash-nav-dropdown-item"><i class="fas fa-question-circle mr-2"></i> Bantuan dan tips </a>
                        <div class="hover-control">
                            <a class="dash-nav-dropdown-item" data-bs-toggle="modal" data-bs-target="#logout" style="cursor: pointer"><i class="fas fa-sign-out-alt mr-2"></i> Logout </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Anda yakin ingin logout?</div>
                    <div class="modal-footer">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-outline-danger">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-app">
            <header class="dash-toolbar">
                <a href="#!" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </a>
                {{-- <div class="tools">
                    <div class="clock">
                        <button type="submit" class="btn" id="time" disabled></button>
                    </div>
                </div> --}}
                <div class="tools mr-lg-4">
                    <a class="tools-item" title="Clock">
                        <div class="clock mr-4">
                            <button type="submit" class="btn" id="time" disabled></button>
                        </div>
                    </a>
                    <div class="dropdown">
                        <a class="tools-item ml-2 tools-control col-auto dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer" title="Profile">
                            <img src="{{url('/assets/'.Auth::user()->image ??'')}}" alt="..." width="30" height="30" class="rounded-circle border border-white" style="object-fit: cover;">
                            <p class="pt-3 ml-2 mr-2">{{ucwords($forename)}} {{ucwords($surname)}}</p>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="/main/editakun/{{Auth::user()->id ??''}}"><i class="fas fa-user-alt mr-2"></i> Akun</a>    
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logout" style="cursor: pointer"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>     
                        </div>
                    </div>
                </div>
            </header>
            <div class="container mb-3">
                {{-- Content --}}
                <!-- Bagian Judul -->
                <br>
                    <h4 class="container">@yield('judul_halaman')</h4>
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
	<script src="/js/bootstrap.min.js"></script>
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
    @include('sweetalert::alert')
</body>

</html>