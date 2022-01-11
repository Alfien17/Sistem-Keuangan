@extends('main')
@section('judul_halaman','Rekap Keuangan')
@section('konten')
<br>
<div class="container">
    @if(Session::has('g_delete'))
    <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_delete')}}
    </div>
    @endif
    <div class="d-flex justify-content-between">
        <div class="dropdown">
            <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Toggle Column
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="toggle-vis dropdown-item cursor" data-column="0">#</a></li>
                <li><a class="toggle-vis dropdown-item cursor" data-column="1">Tanggal</a></li>
                <li><a class="toggle-vis dropdown-item cursor" data-column="2">Kode</a></li>
                <li><a class="toggle-vis dropdown-item cursor" data-column="3">Buku Kas</a></li>
                <li><a class="toggle-vis dropdown-item cursor" data-column="4">Cash/Cashless</a></li>
                <li><a class="toggle-vis dropdown-item cursor" data-column="5">Kategori</a></li>
                <li><a class="toggle-vis dropdown-item cursor" data-column="6">Debit</a></li>
                <li><a class="toggle-vis dropdown-item cursor" data-column="7">Kredit</a></li>
            </ul>
        </div>
    </div>
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-center">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th data-priority="1">Kode</th> 
                            <th>Buku Kas</th>
                            <th>Cash/Cashless</th>
                            <th>Kategori</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th data-priority="2">Option</th>
                        </tr>
                    </thead>
                    <tbody class=" text-left">
                    <?php $id = 1 ?>
                    @forelse($keuangan as $k)
                        <tr>
                            <td>{{$id++}}</td>
                            <td>{{date('d-m-Y', strtotime($k->tanggal))}}</td>
                            @if(!empty($k->akun->kd_akun))
                                <td>{{$k->akun->kd_akun}}</td>
                            @else
                                <td></td>
                            @endif
                            @if(!empty($k->kas->bk_kas))
                                <td>{{ucwords($k->kas->bk_kas)}}</td>
                            @else
                                <td></td>
                            @endif
                            @if(!empty($k->kas->tipe))
                                <td>{{ucwords($k->kas->tipe)}}</td>
                            @else
                                <td></td>
                            @endif
                            @if(!empty($k->kategori->name))
                                <td>{{ucwords($k->kategori->name)}}</td>
                            @else
                                <td></td>
                            @endif
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
                            <td>
                                <a type="button" class="btn btn-outline-custom2" href="/main/keuangan/detail/{{$k->id}}" title="Detail"><i class="fas fa-info text-dark pl-1 pr-1"></i></a>
                                @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                    <a type="button" class="btn btn-outline-custom2" href="/main/keuangan/update/{{$k->id}}" title="Edit"><i class="far fa-edit text-dark"></i></a>
                                    <button type="button" class="btn btn-outline-custom2" title="Delete" data-bs-toggle="modal" data-bs-target="#delete{{$k->id}}"><i class="fas fa-trash text-dark"></i></button>
                                @endif

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="delete{{$k->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Anda yakin ingin menghapus data pada baris ini?</div>
                                            <div class="modal-footer">
                                                <form action="/drekap/{{$k->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-custom">Yes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            @if(!empty($k))
            <p><small>*Tabel diurutkan berdasarkan input terbaru.</small></p>
            @endif
        </div>
    </div>
</div>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                },
                responsive: true,
                "order": [[ 0, "asc" ]],
                dom: 
                "<'row'<'col-2 text-left'l><'col-10 text-right 'f>>" +
                "<'row'<'col-sm-12'tr>>"+
                "<'row'<'col-md-6'i><'col-md-6'p>>",
                lengthMenu:[
                    [10,25,50,100,-1],
                    [10,25,50,100,"All"]
                ]
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