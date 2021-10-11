@extends('main')
@section('judul_halaman','Rekap Keuangan')
@section('konten')
<br>
<div class="container">
    @if(Session::has('g_delete'))
    <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_delete')}}
    </div>
    @endif
    <div class="d-flex flex-row-reverse">
        <form action="/searchrekap" method="get">
            <div class="input-group">
                <input value="{{Request::get('search')}}" type="search" name="search" class="form-control border-secondary" autocomplete="off" placeholder="Cari..." title="Search" aria-describedby="button-addon1">
                <button type="submit" class="btn btn-secondary" id="button-addon1"><i class="fas fa-search" title="Search"></i></button>
            </div>
        </form>
        {{-- <div class="pr-2">
            <button title="Delete All" class="btn btn-danger delete_all" data-url="{{ url('deleterekap') }}"><i class="fas fa-trash"></i></button>
        </div> --}}
    </div>
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-left">
                        <tr>
                            {{-- <th><input type="checkbox" id="master"></th> --}}
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
                        <tr id="tr_{{$k->id}}">
                            {{-- <td><input type="checkbox" class="sub_chk" data-id="{{$k->id}}"></td> --}}
                            <td>{{$id++}}</td>
                            <td>{{date('d-m-Y', strtotime($k->tanggal))}}</td>
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
                            <td>
                                <a href="/main/keuangan/detail/{{$k->id}}" role="button" title="Detail"><i class="fas fa-info text-dark mr-2"></i></a>
                                <a href="/main/keuangan/update/{{$k->id}}" role="button" title="Edit"><i class="far fa-edit text-dark"></i></a>
                                <button class="bg-transparent" title="Delete" style="border: none" data-bs-toggle="modal" data-bs-target="#delete{{$k->id}}"><i class="fas fa-trash text-dark"></i></button>

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="delete{{$k->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Anda yakin ingin menghapus data pada baris ini?</div>
                                            <div class="modal-footer">
                                                <form action="/drekap/{{$k->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-outline-danger">Yes</button>
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
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ],
                "aoColumnDefs": [
                    { "bSortable": false, 'aTargets': [ 0,9]}
                ],
                "order": [[ 0, "asc" ]],
                buttons: [ 'excel', 'pdf'],
                dom: 
                "<'row'<'col-2 text-left'l>>" +
                "<'row'<'col-sm-12'tr>>"+
                "<'row'<'col-md-6'i><'col-md-6'p>>",
                lengthMenu:[
                    [10,25,50,100,-1],
                    [10,25,50,100,"All"]
                ]
            } );
            
            table.buttons().container()
            .appendTo( '#table_wrapper .col-md-5:eq(0)' );
        } );
    </script>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#master').on('click', function(e) {
            if($(this).is(':checked',true))  
            {
                $(".sub_chk").prop('checked', true);  
            } else {  
                $(".sub_chk").prop('checked',false);  
            }  
        });

        $('.delete_all').on('click', function(e) {
            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  
            if(allVals.length <=0)  
            {  
                alert("Tidak ada baris yang dipilih!");  
            }  else {  
                var check = confirm("Anda yakin ingin menghapus baris yang dipilih?");  
                if(check == true){  
                    var join_selected_values = allVals.join(","); 
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
                    $.each(allVals, function( index, value ) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }  
            }  
        });

        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });

        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();
            $.ajax({
                url: ele.href,
                type: 'get',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
            return false;
        });
    });
    </script>
@endsection	