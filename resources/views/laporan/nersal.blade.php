@extends('main')
@section('judul_halaman','Neraca Saldo')
@section('konten')
<br>
<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main/laporan-neracasaldo">Pilih-tanggal</a></li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
    </nav>
    <div class="dropdown">
        <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Toggle Column
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="toggle-vis dropdown-item cursor" data-column="0">Nomor Akun</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="1">Nama Akun</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="2">Debit</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="3">Kredit</a></li>
        </ul>
    </div>
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-center">
                        <tr>
                            <th data-priority="1">Nomor Akun</th> 
                            <th>Nama Akun</th>
                            <th>Debit</th>
                            <th>kredit</th>
                        </tr>
                    </thead>
                    <tbody class=" text-left">
                        @forelse($kategori as $k)
                        <tr>
                            <th class="text-center">{{$k->kode}}</th>
                            <th>{{ucwords($k->akun)}}</th>
                            <td></td>
                            <td></td>
                        </tr>
                            @foreach($data as $d)
                                @if($k->id == $d->katakun_id)
                                    <tr>
                                        <td class="text-center">{{$d->kd_akun}}</td>
                                        <td>{{ucwords($d->nama_akun)}}</td>
                                        @if($d->posisi == 'debit')
                                            @foreach($saldo as $s)
                                                @if ($s->kd_akun == $d->kd_akun)
                                                    <td>
                                                        @if(!empty($s->sum))
                                                            Rp. {{number_format((float)$s->sum)}}
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                        @else
                                            <td></td>
                                        @endif
                                        @if($d->posisi == 'kredit')
                                            @foreach($saldo as $s)
                                                @if ($s->kd_akun == $d->kd_akun)
                                                    <td>
                                                        @if(!empty($s->sum))
                                                            Rp. {{number_format((float)$s->sum*-1)}}
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        @empty
                            <tr class="text-center">
                                <td colspan="4">
                                    <div class="content m-5">
                                        <div class="icon"><i class="far fa-sad-tear"></i></div>
                                        <div class="text2 ml-4">Data Kosong.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td></td>
                            <th>TOTAL</th>
                            @foreach($total as $t)
                                @if($t->posisi == 'debit')
                                    <th>Rp. {{number_format((float)$t->sum)}}</th>
                                @else
                                    <th>Rp. {{number_format((float)$t->sum*-1)}}</th>
                                @endif
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                "paging":   false,
                "ordering": false,
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ],
                "order": [[ 0, "asc" ]],
                buttons: [
                    {
                        text: '<i class="far fa-file-excel"></i> Excel',
                        extend: 'excel',
                        title: 'Jurnal Umum IAC {{$month2}} {{$year2}}',
                        messageTop: 'Tanggal : {{$month2}} {{$year2}}',
                    },
                    {
                        text: '<i class="far fa-file-pdf"></i> PDF',
                        extend: 'pdf',
                        title: 'Jurnal Umum IAC {{$month2}} {{$year2}}',
                        messageTop: 'Tanggal : {{$month2}} {{$year2}}',
                    },
                    {
                        text: '<i class="fas fa-print"></i> Print',
                        extend: 'print',
                        title: 'Jurnal Umum IAC {{$month2}} {{$year2}}',
                        messageTop: 'Tanggal : {{$month2}} {{$year2}}',
                    },
                    
                ],
                dom: 
                "<'row'<'col-md-12 text-right'B>>" +
                "<'row'<'col-sm-12'tr>>"+
                "<'row'<'col-sm-12'i>>",
            } );
            
        table.buttons().container()
        .appendTo( '#table_wrapper .col-md-5:eq(0)' );

        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
                // Toggle the visibility
                column.visible( ! column.visible() );
            } );
        } );
    </script>
@endsection	