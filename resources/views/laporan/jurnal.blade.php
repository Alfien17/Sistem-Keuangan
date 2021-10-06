@extends('main')
@section('judul_halaman','Jurnal Umum')
@section('konten')
<br>
<div class="container">
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
                            <th>Cash/Cashless</th>
                            <th>Nama Akun</th>
                            <th>Keterangan</th>
                            <th>Kategori</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody class=" text-left">
                    <?php $id = 1 ?>
                    @forelse($keuangan as $k)
                        <tr>
                            <td>{{$id++}}</td>
                            <td>{{date('d F Y', strtotime($k->tanggal))}}</td>
                            <td>
                                @foreach ($akun as $a)
                                    @if($k->akun_id == $a->id)
                                    {{$a->kd_akun}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($kas as $a)
                                    @if($k->kas_id == $a->id)
                                    {{ucwords($a->bk_kas)}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($kas as $a)
                                    @if($k->kas_id == $a->id)
                                    {{$a->tipe}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($akun as $a)
                                    @if($k->akun_id == $a->id)
                                    {{ucwords($a->nama_akun)}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ucfirst($k->ket)}}</td>
                            <td>
                                @foreach ($kat as $a)
                                    @if($k->kat_id == $a->id)
                                    {{ucwords($a->name)}}
                                    @endif
                                @endforeach
                            </td>
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
	                		        <div class="text ml-4">Data Kosong.</div>
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
                        title: 'Jurnal Umum IAC',
                        messageTop: 'Tanggal : ',
                    },
                    {
                        text: '<i class="far fa-file-pdf"></i> PDF',
                        extend: 'pdf',
                        title: 'Jurnal Umum IAC',
                        messageTop: 'Tanggal : ',
                    },
                ],
                dom: 
                "<'row'<'col-md-12 text-right'B>>" +
                "<'row'<'col-sm-12'tr>>"+
                "<'row'<'col-sm-12'i>>",
            } );
            
            table.buttons().container()
            .appendTo( '#table_wrapper .col-md-5:eq(0)' );
        } );
    </script>
@endsection	