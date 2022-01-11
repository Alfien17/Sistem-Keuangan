<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="/fontawesome-free-5.15.3-web/css/all.css">
    <link rel="stylesheet" type="text/css" href="/css/spur.css">
    <link rel="stylesheet" type="text/css" href="/css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/font.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-imageupload.css">
    <link rel="stylesheet" type="text/css" href="/css/fixedHeader.dataTables.min.css">
    <script src="/js/Chart.bundle.min.js"></script>
    <script src="/js/chart-js-config.js"></script>
    @livewireStyles
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

    <title>IAC Finance</title>

        <div class="sidebar close">
            <div class="logo-details">
                <img class="mr-4 ml-3 mt-1" src="/img/alpin.png" alt="">
                <span class="logo_name">IAC</span>
            </div>
            <ul class="nav-links">
                <li id="{{ Route::currentRouteNamed('main') ? 'active' : '' }}">
                    <a href="/main">
                        <i class='bx bx-grid-alt'></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="/main">Dashboad</a></li>
                    </ul>
                </li>
                @if(Auth::user()->bagian != 'admin')
                    <li id="{{ Route::currentRouteNamed('dataakun') ? 'active' : '' }}">
                        <a href="/main/akun">
                            <i class='fas fa-folder' ></i>
                            <span class="link_name">Data Akun</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="/main/akun">Data Akun</a></li>
                        </ul>
                    </li>
                    <li id="{{ Route::currentRouteNamed('datakas') ? 'active' : '' }}">
                        <a href="/main/kas">
                            <i class='fas fa-folder' ></i>
                            <span class="link_name">Data Kas</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="/main/kas">Data Kas</a></li>
                        </ul>
                    </li>
                    <li id="{{ Route::currentRouteNamed('datakat') ? 'active' : '' }}">
                        <a href="/main/kategori">
                            <i class='fas fa-folder' ></i>
                            <span class="link_name">Data Kategori</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="/main/kategori">Data Kategori</a></li>
                        </ul>
                    </li>
                    <li 
                    id="{{ Route::currentRouteNamed('masuk') ? 'active' : '' }}{{ Route::currentRouteNamed('keluar') ? 'active' : '' }}{{ Route::currentRouteNamed('rekap') ? 'active' : '' }}" 
                    class="{{ Route::currentRouteNamed('masuk') ? 'showMenu' : '' }}{{ Route::currentRouteNamed('keluar') ? 'showMenu' : '' }}{{ Route::currentRouteNamed('rekap') ? 'showMenu' : '' }}">
                        <div class="iocn-link">
                            <a href="#">
                                <i class='fas fa-donate' ></i>
                                <span class="link_name">Keuangan</span>
                            </a>
                            <i class='bx bxs-chevron-down arrow' ></i>
                        </div>
                        <ul class="sub-menu">
                            <li><a class="link_name" href="#">Keuangan</a></li>
                            @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                <li><a href="/main/keuangan/addin" id="{{ Route::currentRouteNamed('masuk') ? 'active' : '' }}">Tambah Debit</a></li>
                                <li><a href="/main/keuangan/addout" id="{{ Route::currentRouteNamed('keluar') ? 'active' : '' }}">Tambah Kredit</a></li>
                                {{-- <li><a href="/main/keuangan/in-out" id="{{ Route::currentRouteNamed('multi') ? 'active' : '' }}">Tambah Kredit dan Kredit</a></li> --}}
                            @endif
                            <li><a href="/main/keuangan" id="{{ Route::currentRouteNamed('rekap') ? 'active' : '' }}">Rekap</a></li>
                        </ul>
                    </li>
                @else
                    <li id="{{ Route::currentRouteNamed('datauser') ? 'active' : '' }}">
                        <a href="/main/datauser">
                            <i class='fas fa-folder' ></i>
                            <span class="link_name">Data User</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="/main/datauser">Data User</a></li>
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->bagian == 'accounting')
                    <li
                    id="{{ Route::currentRouteNamed('jurnal') ? 'active' : '' }}{{ Route::currentRouteNamed('lakun') ? 'active' : '' }}{{ Route::currentRouteNamed('lkas') ? 'active' : '' }}{{ Route::currentRouteNamed('nersal') ? 'active' : '' }}"
                    class="{{ Route::currentRouteNamed('jurnal') ? 'showMenu' : '' }}{{ Route::currentRouteNamed('lakun') ? 'showMenu' : '' }}{{ Route::currentRouteNamed('lkas') ? 'showMenu' : '' }}{{ Route::currentRouteNamed('nersal') ? 'showMenu' : '' }}">
                        <div class="iocn-link">
                            <a href="#">
                                <i class='bx bx-file' ></i>
                                <span class="link_name">Laporan</span>
                            </a>
                            <i class='bx bxs-chevron-down arrow' ></i>
                        </div>
                        <ul class="sub-menu">
                            <li><a class="link_name" href="#">Laporan</a></li>
                            <li><a href="/main/laporan-jurnal" id="{{ Route::currentRouteNamed('jurnal') ? 'active' : '' }}">Jurnal Umum</a></li>
                            <li><a href="/main/laporan-akun" id="{{ Route::currentRouteNamed('lakun') ? 'active' : '' }}">Buku Besar (Akun)</a></li>
                            <li><a href="/main/laporan-kas" id="{{ Route::currentRouteNamed('lkas') ? 'active' : '' }}">Buku Besar (Buku Kas)</a></li>
                            <li><a href="/main/laporan-neracasaldo" id="{{ Route::currentRouteNamed('nersal') ? 'active' : '' }}">Neraca Saldo</a></li>
                        </ul>
                    </li>
                @endif
                <li
                id="{{ Route::currentRouteNamed('reset') ? 'active' : '' }}{{ Route::currentRouteNamed('editprofil') ? 'active' : '' }}{{ Route::currentRouteNamed('help') ? 'active' : '' }}"
                class="{{ Route::currentRouteNamed('reset') ? 'showMenu' : '' }}{{ Route::currentRouteNamed('editprofil') ? 'showMenu' : '' }}{{ Route::currentRouteNamed('help') ? 'showMenu' : '' }}">
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx bx-cog' ></i>
                            <span class="link_name">Lainnya</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Lainnya</a></li>
                        @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                            <li><a href="/main/reset-data" id="{{ Route::currentRouteNamed('reset') ? 'active' : '' }}">Reset Data</a></li>
                        @endif
                        <li><a href="/main/profil" id="{{ Route::currentRouteNamed('editprofil') ? 'active' : '' }}">Profil</a></li>
                        <li><a href="/main/help" id="{{ Route::currentRouteNamed('help') ? 'active' : '' }}">Bantuan dan Tips</a></li>
                    </ul>
                </li>
                <li>
                    <div class="profile-details" style="cursor: pointer">
                        <div class="profile-content">
                            <a href="/main/profil"><img src="{{url('/assets/'.Auth::user()->image ??'')}}" alt="profileImg"></a>
                        </div>
                        <div class="name-job">
                            <a href="/main/profil" class="profile_name" >
                            @if (strlen(Auth::user()->name) >= 10)
                                {{ucwords(substr(Auth::user()->name,0,10))}}...
                            @else
                                {{ucwords(Auth::user()->name)}}
                            @endif
                            </a>
                            <div class="job">{{ucfirst(Auth::user()->bagian)}}</div>
                        </div>
                        <i class='bx bx-log-out' data-bs-toggle="modal" data-bs-target="#logout" title="Logout"></i>
                    </div>
                </li>
            </ul>
        </div>
    
    <section class="home-section">
            <header class="header-navigation" id="header">
                <div class="home-content">
                    <i class='bx bx-menu' ></i>
                    {{-- <div class=" tools">
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
                    </div> --}}
                </div>
            </header>
        <div class="container pb-3">
            {{-- Content --}}
            <!-- Bagian Judul -->
            <br>
            @if(!Route::is('main') )
            <h4 class="container pt-5">@yield('judul_halaman')</h4>
            @endif
            <!-- Bagian Konten -->
            @yield('konten')
            <footer class="site-footer">
                <p>&copy; 2021 @if($year!=2021)- {{$year}}@endif IAC | All rights reserved</p>
            </footer>
        </div>
    </section>

    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Anda yakin ingin logout?</div>
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Yes</button>
                    </form>
                </div>
            </div>
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
    <script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>

	<script src="/js/bootstrap.min.js"></script>
    <script src="/js/spur.js"></script>
    <script src="/js/sidebar.js"></script>
    <script src="/js/bootstrap-imageupload.js"></script>

    @livewireScripts
    <script>
    var new_scroll_position = 0;
    var last_scroll_position;
    var header = document.getElementById("header");

    window.addEventListener('scroll', function(e) {
    last_scroll_position = window.scrollY;

    // Scrolling down
    if (new_scroll_position < last_scroll_position && last_scroll_position > 100) {
        // header.removeClass('slideDown').addClass('slideUp');
        header.classList.remove("slideDown");
        header.classList.add("slideUp");

    // Scrolling up
    } else if (new_scroll_position > last_scroll_position) {
        // header.removeClass('slideUp').addClass('slideDown');
        header.classList.remove("slideUp");
        header.classList.add("slideDown");
    }

    new_scroll_position = last_scroll_position;
    });
    </script>
    @include('sweetalert::alert')
</body>

</html>