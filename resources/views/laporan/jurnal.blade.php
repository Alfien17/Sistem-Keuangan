@extends('main')
@section('judul_halaman','Jurnal Umum')
@section('konten')
<br>
<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main/laporan-jurnal">Pilih-tanggal</a></li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
    </nav>
    <div class="dropdown">
        <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Toggle Column
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="toggle-vis dropdown-item cursor" data-column="0">No</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="1">Tanggal</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="2">Ref</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="3">Buku Kas</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="4">Cash/Cashless</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="5">Nama Akun</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="6">Keterangan</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="7">Kategori</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="8">Debit</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="9">Kredit</a></li>
        </ul>
    </div>
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th data-priority="1">Ref</th> 
                            <th data-priority="2">Buku Kas</th>
                            <th data-priority="7">Cash/Cashless</th>
                            <th data-priority="6">Nama Akun</th>
                            <th>Keterangan</th>
                            <th data-priority="5">Kategori</th>
                            <th data-priority="3">Debit</th>
                            <th data-priority="4">Kredit</th>
                        </tr>
                    </thead>
                    <tbody class=" text-left">
                    <?php $id = 1 ?>
                    @forelse($keuangan as $k)
                        <tr>
                            <td>{{$id++}}</td>
                            <td>{{date('d F Y', strtotime($k->tanggal))}}</td>
                            <td>{{$k->akun->kd_akun}}</td>
                            <td>{{ucwords($k->kas->bk_kas)}}</td>
                            <td>{{$k->kas->tipe}}</td>
                            <td>{{ucwords($k->akun->nama_akun)}}</td>
                            <td>{{ucfirst($k->ket)}}</td>
                            <td>{{ucwords($k->kategori->name)}}</td>
                            @if ($k->debit==0)
                                <td></td>
                            @else
                                <td>Rp. {{number_format((float)$k->debit)}}</td>
                            @endif
                            @if ($k->kredit==0)
                                <td></td>  
                            @else
                                <td>Rp. {{number_format((float)$k->kredit)}}</td> 
                            @endif
                        </tr>
                        @empty
	                    <tr class="text-center">
	            	        <td colspan="10">
	            		        <div class="content m-5">
		            		        <div class="icon"><i class="far fa-sad-tear"></i></div>
	                		        <div class="text2 ml-4">Data Kosong.</div>
                		        </div>
            		        </td>
	                    </tr>
                        @endforelse
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td> 
                            <td></td>
                            <th>TOTAL</th>
                            <th>Rp. {{number_format((float)$debit)}}</th>
                            <th>Rp. {{number_format((float)$kredit*-1)}}</th>
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