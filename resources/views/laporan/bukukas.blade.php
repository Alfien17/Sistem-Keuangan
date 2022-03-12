@extends('main')
@section('konten')
<h4 class="container">{{ucwords($input->bk_kas)}}</h4>
<h6 class="container pb-2">{{$month2}} {{ucfirst($year2)}}</h6>

<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main/laporan-kas">Pilih-Kas</a></li>
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
            <li><a class="toggle-vis dropdown-item cursor" data-column="2">Keterangan</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="3">Debit</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="4">Kredit</a></li>
            <li><a class="toggle-vis dropdown-item cursor" data-column="5">Saldo</a></li>
        </ul>
    </div>
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-left">
                        <tr>
                            <th>No</th>
                            <th data-priority="1">Tanggal</th>
                            <th data-priority="2">Kode Akun</th>
                            <th>Keterangan</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody class=" text-left">
                    <?php $id = 1 ?>
                        @forelse($data as $d)
                        <tr>
                            <td>{{$id++}}</td>
                            <td>{{date('d F Y', strtotime($d->tanggal))}}</td>
                            <td title="{{ucwords($d->akun->nama_akun)}}" style="cursor: pointer">{{$d->akun->kd_akun}}</td>
                            <td>JU</td>
                            @if ($d->debit==0)
                                <td></td>
                            @else
                                <td>Rp. {{number_format((float)$d->debit)}}</td>
                            @endif
                            @if ($d->kredit==0)
                                <td></td>  
                            @else
                                <td>Rp. {{number_format((float)$d->kredit)}}</td> 
                            @endif
                            <td>
                                @foreach ($saldo as $s)
                                    @if ($s->id == $d->id)
                                    Rp. {{number_format((float)$s->saldo)}}
                                    @endif
                            @endforeach
                            </td>
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
                        title: 'Rekap Buku Kas {{ucwords($input->bk_kas)}} {{$month2}} {{$year2}}',
                        messageTop: 'Nama Buku Kas : {{ucwords($input->bk_kas)}}          Tipe : {{$input->tipe}}',
                    },
                    {
                        text: '<i class="far fa-file-pdf"></i> PDF',
                        extend: 'pdf',
                        title: 'Rekap Buku Kas {{ucwords($input->bk_kas)}} {{$month2}} {{$year2}}',
                        messageTop: 'Nama Buku Kas : {{ucwords($input->bk_kas)}}          Tipe : {{$input->tipe}}',
                    },
                    {
                        text: '<i class="fas fa-print"></i> Print',
                        extend: 'print',
                        title: 'Rekap Buku Kas {{ucwords($input->bk_kas)}} {{$month2}} {{$year2}}',
                        messageTop: 'Nama Buku Kas : {{ucwords($input->bk_kas)}}          Tipe : {{$input->tipe}}',
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