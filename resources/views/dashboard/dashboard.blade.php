@extends('main')
@section('konten')
<div class="container pt-3">
    <div class="accordion pl-1 pr-1" id="accordionExample">
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h5>{{$today}}</h5>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong id="greeting"></strong> {{ucwords(Auth::user()->name ??'')}}. Do your best at every opportunity that you have.</div>
            </div>
        </div>
    </div>
</div>
@if(Auth::user()->bagian != 'admin')
<main class="dash-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <div class="stats stats-light" data-bs-toggle="modal" data-bs-target="#pemasukkan">
                    <div class="d-flex justify-content-between">
                        <div class="card-body-icon">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </div>
                        <h3 class="stats-title"> Pendapatan </h3>
                    </div>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">Rp. {{number_format((float)$pemasukkan2)}}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Pendapatan --}}
            <div class="modal fade" id="pemasukkan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title ml-2" id="exampleModalLabel">Rekap Pendapatan</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless">
                                @forelse ($cardin as $c)
                                <tr>
                                    <th 
                                    @foreach ($sortakun as $s)
                                        @if ($s->kd_akun == $c->kd_akun)
                                            title="{{ucwords($s->nama_akun)}}"
                                        @endif
                                    @endforeach 
                                    style="cursor: pointer">{{$c->kd_akun}}</th>
                                    <td>:</td>
                                    <td>
                                        <a class="float-left">Rp.</a> 
                                        <a class="float-right">{{number_format((float)$c->pendapatan)}}</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th>Data Kosong.</th>
                                </tr>   
                                @endforelse
                                <tr class="dropdown-divider">
                                    <th>Total</th>
                                    <td>:</td>
                                    <td><a class="float-left">Rp.</a> <a class="float-right">{{number_format((float)$pemasukkan2)}}</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="stats stats-light" data-bs-toggle="modal" data-bs-target="#biaya">
                    <div class="d-flex justify-content-between">
                        <div class="card-body-icon">
                            <i class="fa-solid fa-money-bill-1-wave"></i>
                        </div>
                        <h3 class="stats-title"> Biaya </h3>
                    </div>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">Rp. {{number_format((float)$biaya)}}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Biaya --}}
            <div class="modal fade" id="biaya" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title ml-2" id="exampleModalLabel">Rekap Biaya</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless">
                                @forelse ($cardout as $c)
                                <tr>
                                    <th 
                                    @foreach ($sortakun as $s)
                                        @if ($s->kd_akun == $c->kd_akun)
                                            title="{{ucwords($s->nama_akun)}}"
                                        @endif
                                    @endforeach 
                                    style="cursor: pointer">{{$c->kd_akun}}</th>
                                    <td>:</td>
                                    <td>
                                        <a class="float-left">Rp.</a> 
                                        <a class="float-right">{{number_format((float)$c->biaya)}}</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th>Data Kosong.</th>
                                </tr>   
                                @endforelse
                                <tr class="dropdown-divider">
                                    <th>Total</th>
                                    <td>:</td>
                                    <td><a class="float-left">Rp.</a> <a class="float-right">{{number_format((float)$biaya)}}</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="stats stats-light" data-bs-toggle="modal" data-bs-target="#selisih">
                    <div class="d-flex justify-content-between">
                        <div class="card-body-icon">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h3 class="stats-title"> Selisih </h3>
                    </div>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">
                                @if ($saldo<0)
                                    Rp. ({{number_format((float)$saldo*-1)}})</div>
                                @else
                                    Rp. {{number_format((float)$saldo)}}</div>
                                @endif 
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Selisih --}}
            {{-- <div class="modal fade" id="selisih" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title ml-2" id="exampleModalLabel">Rekap Biaya</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless">
                                @forelse ($sort as $y)
                                <tr>
                                    <th>Tahun {{$y->year}}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @foreach ($month2 as $m)
                                @if ($m->year == $y->year)
                                <tr>
                                    <td>
                                        @foreach ($month as $m2)
                                            @if ($m->month == $m2->month)
                                            {{$m->month}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>:</td>
                                    <td> 
                                        <a class="float-left">Rp.</a> 
                                        <a class="float-right">
                                        @foreach($month as $m2)
                                            @foreach ($chart as $c)
                                                @if ($m2->month == $c->month)
                                                    {{number_format((float)$c->total)}}
                                                @endif
                                            @endforeach
                                        @endforeach
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach 
                                @empty
                                <tr>
                                    <th>Data Kosong.</th>
                                </tr>   
                                @endforelse
                                <tr class="dropdown-divider">
                                    <th>Total</th>
                                    <td>:</td>
                                    <td><a class="float-left">Rp.</a> <a class="float-right">{{number_format((float)$saldo)}}</div></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-xl-3" data-bs-toggle="modal" data-bs-target="#ratio">
                <div class="stats stats-light">
                   <div class="d-flex justify-content-between">
                        <div class="card-body-icon pl-2 pr-2">
                            <i class="fa-solid fa-percent"></i>
                        </div>
                        <h3 class="stats-title"> Rasio </h3>
                    </div>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">{{number_format((float)$ratio)}}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Ratio --}}
            {{-- <div class="modal fade" id="ratio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title ml-2" id="exampleModalLabel">Rekap Biaya</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless">
                                @forelse ($sort as $y)
                                <tr>
                                    <th>Tahun {{$y->year}}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @foreach ($month as $m)
                                <tr>
                                    <td>{{$m->month}}</td>
                                    <td>:</td>
                                    <td class="float-right">
                                        @foreach ($cardrat as $c)
                                            @if ($m->month == $c->month)
                                                {{number_format((float)$c->ratio)}}%
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach 
                                @empty
                                <tr>
                                    <th>Data Kosong.</th>
                                </tr>   
                                @endforelse
                                <tr class="dropdown-divider">
                                    <th>Total</th>
                                    <td>:</td>
                                    <td><a class="float-left">Rp.</a> <a class="float-right">{{number_format((float)$ratio)}}%</div></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
    
        <div class="row">
            <div class="col-xl-8">
                <div class="card spur-card">
                    <div class="card-header">
                        <div class="spur-card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="spur-card-title">Saldo per Bulan di Tahun 
                            @if (empty($year2)&&!empty($year3))
                                {{$year}}
                            @elseif (empty($year3)&&!empty($year2))
                                {{$year2}}
                            @else
                                {{$year}}
                            @endif</div>
                            <div class="spur-card-menu">
                                <div class="d-flex flex-row-reverse">
                                    <form action="/main/chart1" method="get">
                                        <div class="input-group">
                                            <select class="form-control border-0 bg-transparent" name="sortir">
                                                <option value="" hidden>Pilih</option>
                                                @foreach($sort as $y)
                                                    <option value="{{($y->year)}}">{{($y->year)}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="bg-transparent border-0"><i class="fas fa-search" title="Search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body spur-card-body-chart">
                            <canvas id="myChart" width="400" height="199"></canvas>
                        </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card spur-card">
                    <div class="card-header">
                        <div class="spur-card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="spur-card-title"> Waktu </div>
                    </div>
                    <div class="card-body ">
                        <div class="notifications">
                            <a class="notification">
                                <div class="notification-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <span id="time"><span>
                                <div class="notification-text"></div>
                                <span class="notification-time"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card spur-card">
                    <div class="card-header">
                        <div class="spur-card-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="spur-card-title"> Informasi Data </div>
                    </div>
                    <div class="card-body ">
                        <div class="notifications">
                            <a href="/main/akun" class="notification">
                                <div class="notification-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                Jumlah Akun : {{$countakun}}
                                <div class="notification-text"></div>
                                <span class="notification-time"></span>
                            </a>
                            <a href="/main/kas" class="notification">
                                <div class="notification-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                Jumlah Buku Kas : {{$kas}}
                                <div class="notification-text"></div>
                                <span class="notification-time"></span>
                            </a>
                            <a href="/main/kategori" class="notification">
                                <div class="notification-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                Jumlah Kategori : {{$kat}}
                                <div class="notification-text"></div>
                                <span class="notification-time"></span>
                            </a>
                            <a href="/main/keuangan" class="notification">
                                <div class="notification-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                Jumlah Record Keuangan : {{$keu/2}}
                                <div class="notification-text"></div>
                                <span class="notification-time"></span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card spur-card">
                    <div class="card-header">
                        <div class="spur-card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="spur-card-title">Neraca Saldo di Tahun 
                            @if (empty($year2)&&!empty($year3))
                                {{$year3}}
                            @elseif (empty($year3)&&!empty($year2))
                                {{$year}}
                            @else
                                {{$year}}
                            @endif</div>
                        <div class="spur-card-menu">
                            <div class="d-flex flex-row-reverse">
                                <form action="/main/chart2" method="get">
                                    <div class="input-group">
                                        <select class="form-control border-0 bg-transparent" name="sortir2">
                                            <option value="" hidden>Pilih</option>
                                            @foreach($sort as $y)
                                                <option value="{{($y->year)}}">{{($y->year)}}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-search" title="Search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body spur-card-body-chart">
                        <div class="row">
                            <div class="col-xl-6">
                                <div style="width: 400px; height: 400px;">
                                    <canvas id="doughnut1"></canvas>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div style="width: 400px; height: 400px;">
                                    <canvas id="doughnut2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@else
<main class="dash-content">
    <div class="container-fluid">
        <div class="row dash-row d-flex justify-content-between">
            <div class="col-xl-3">
                <div class="stats stats-light" data-bs-toggle="modal" data-bs-target="#pemasukkan">
                    <div class="d-flex justify-content-between">
                        <div class="card-body-icon">
                            <i class="fa-regular fa-user pl-1 pr-1"></i>
                        </div>
                        <h3 class="stats-title"> Jumlah User </h3>
                    </div>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">{{$juser}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card spur-card">
                    <div class="card-header">
                        <div class="spur-card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="spur-card-title"> Waktu </div>
                    </div>
                    <div class="card-body ">
                        <div class="notifications">
                            <a class="notification">
                                <div class="notification-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <span id="time"><span>
                                <div class="notification-text"></div>
                                <span class="notification-time"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endif

    <script src="/js/chart.js"></script>
    <script>
        const labels = [
            @foreach ($month as $m)
                '{{ucwords(substr($m->month,0,3))}}',
            @endforeach
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Saldo',
                backgroundColor: '#2D3E50',
                borderColor: '#2D3E50',
                data:[
                    @foreach ($month as $m) 
                        @foreach ($chart as $c)
                            @if ($m->month == $c->month)
                                {{$c->total}},
                            @endif
                        @endforeach
                    @endforeach
                ],
            }]
        };

        const config = {
            type: 'line',
            data: data,
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
    <script>
        const labels2 = [
            @forelse ($chart2 as $c)
                '{{$c->kd_akun}}',
            @empty
                'n/a'
            @endforelse
        ];

        const data2 = {
            labels: labels2,
            datasets: [{
            label: 'Neraca Saldo Debit',
                backgroundColor: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80','#8d98b3','#e5cf0d',
                '#97b552','#95706d','#dc69aa','#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050','#59678c',
                '#c9ab00','#7eb00a','#6f5553','#c14089',
                ],
                data: [
                    @forelse($chart2 as $c)
                        @if($c->total>0)
                            {{$c->total}},
                        @else
                            {{$c->total*-1}},
                        @endif
                    @empty
                        0
                    @endforelse
                ],
                nama_akun: [
                    @foreach($chart2 as $c)
                        @foreach($akun as $a)
                            @if($c->kd_akun == $a->kd_akun)
                                '{{$a->nama_akun}}',
                            @endif
                        @endforeach
                    @endforeach
                ]
            }]
        };
                            
        const config2 = {
            type: 'doughnut',
            data: data2,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Neraca Saldo Debit'
                    },
                },
            },
        };

        const myChart2 = new Chart(
            document.getElementById('doughnut1'),
            config2
        );
    </script>
    <script>
        const labels3 = [
            @forelse ($chart3 as $c)
                '{{$c->kd_akun}}',
            @empty
                'n/a'
            @endforelse
        ];

        const data3 = {
            labels: labels3,
            datasets: [{
            label: 'Neraca Saldo Kredit',
                backgroundColor: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80','#8d98b3','#e5cf0d',
                '#97b552','#95706d','#dc69aa','#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050','#59678c',
                '#c9ab00','#7eb00a','#6f5553','#c14089',
                ],
                data: [
                    @forelse($chart3 as $c)
                        @if($c->total>0)
                            {{$c->total}},
                        @else
                            {{$c->total*-1}},
                        @endif
                    @empty
                        0,
                    @endforelse
                ],
                nama_akun: [
                    @foreach($chart3 as $c)
                        @foreach($akun as $a)
                            @if($c->kd_akun == $a->kd_akun)
                                '{{$a->nama_akun}}',
                            @endif
                        @endforeach
                    @endforeach
                ]
            }]
        };
                            
        const config3 = {
            type: 'doughnut',
            data: data3,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Neraca Saldo Kredit'
                    },
                },
            },
        };

        const myChart3 = new Chart(
            document.getElementById('doughnut2'),
            config3
        );
    </script>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
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
@endsection	