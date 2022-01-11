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
        <div class="row dash-row">
            <div class="col-xl-4">
                <div class="stats stats-success">
                    <div class="card-body-icon">
                        <i class="fas fa-donate"></i>
                    </div>
                    <h3 class="stats-title"> Pemasukan </h3>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">Rp. {{number_format((float)$debit)}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="stats stats-danger ">
                    <div class="card-body-icon">
                        <i class="fas fa-cart-arrow-down"></i>
                    </div>
                    <h3 class="stats-title"> Pengeluaran </h3>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">Rp. {{number_format((float)$kredit)}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 saldo-control" data-bs-toggle="modal" data-bs-target="#saldo">
                <div class="stats stats-primary">
                    <div class="card-body-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="stats-title"> Saldo </h3><p class="fw-light">Click to detail</p>
                    <div class="stats-content">
                        <div class="stats-data">
                            <div class="stats-number">Rp. {{number_format((float)$saldo)}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Saldo --}}
        <div class="modal fade" id="saldo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-2" id="exampleModalLabel">Saldo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            @forelse ($kode as $k)
                            @if($k->total!=0)
                            <tr>
		                        <th>
                                    Saldo {{$k->kd_akun}}
                                </th>
                                <td>
                                    :
                                </td>
		                        <td>
                                    <a class="float-left">Rp.</a> <a class="float-right">{{number_format((float)$k->total)}}</a>
                                </td>
		                    </tr>
                            @endif 
                            @empty
                            <tr>
		                        <th></th>
		                    </tr>   
                            @endforelse
                            <tr class="dropdown-divider">
		                        <th>Saldo Total</th>
                                <td>:</td>
		                        <td><a class="float-left">Rp.</a> <a class="float-right">{{number_format((float)$saldo)}}</a></td>
		                    </tr>
		                </table>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-xl-8">
                <div class="card spur-card">
                    <div class="card-header">
                        <div class="spur-card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="spur-card-title">Rekap Keuangan Tahun @if(empty($year2)){{$year}}@else{{$year2}}@endif</div>
                            <div class="spur-card-menu">
                                <div class="d-flex flex-row-reverse">
                                    <form action="/main/year" method="get">
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
                            <canvas id="spurChartjsBar"></canvas>
                            <script>
                                var ctx = document.getElementById("spurChartjsBar").getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            "Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nov","Des"
                                        ],
                                        datasets: [{
                                            data: [
                                                {{$jan}},{{$feb}},{{$mar}},{{$apr}},{{$mei}},{{$jun}},
                                                {{$jul}},{{$ags}},{{$sep}},{{$okt}},{{$nov}},{{$des}}    
                                            ],
                                            backgroundColor: '#2D3E50',
                                            borderColor: 'transparent'
                                        }]
                                    },
                                    options: {
                                        legend: {
                                            display: false
                                        },
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script> 
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
                                Jumlah Akun : {{$akun}}
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
                                Jumlah Record Debit : {{$d_debit}}
                                <div class="notification-text"></div>
                                <span class="notification-time"></span>
                            </a>
                            <a href="/main/keuangan" class="notification">
                                <div class="notification-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                Jumlah Record Kredit : {{$d_kredit}}
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
@else
<main class="dash-content">
    <div class="container-fluid">
        <div class="row dash-row">
            <div class="col-xl-8">
                <div class="stats stats-secondary">
                    <div class="card-body-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stats-title"> Jumlah User </h3>
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