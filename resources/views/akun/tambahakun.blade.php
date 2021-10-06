@extends('main')
@section('judul_halaman','Data Akun')
@section('konten')
<br>
<div class="container">
    @if (count($errors)>0)
    <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
        <ul style="list-style:none">
            @foreach($errors->all() as $error)
            <li><span class="fas fa-exclamation-triangle"></span>
            {{$error}}</li>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            @endforeach
        </ul>  
        </div>
    @endif
    @if(Session::has('a_akun'))
        <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-check-circle"></i> {{Session::get('a_akun')}}
        </div>
    @endif
    @if(Session::has('d_akun'))
        <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-check-circle"></i> {{Session::get('d_akun')}}
        </div>
    @endif
    @if(Session::has('u_akun'))
        <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-check-circle"></i> {{Session::get('u_akun')}}
        </div>
    @endif

    <div class="d-flex flex-row-reverse">
        <form action="/searchakun" method="get">
            <div class="input-group">
                <input value="{{Request::get('search')}}" type="search" name="search" class="typeahead form-control border-secondary" autocomplete="off" placeholder="Cari Akun..." title="Search" aria-describedby="button-addon1">
                <button type="submit" class="btn btn-secondary" id="button-addon2"><i class="fas fa-search" title="Search"></i></button>
            </div>
        </form>
        <div class="pr-2">
            <button title="Add" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add"><i class="fas fa-plus"></i></button>   
        </div>
        {{-- <div class="pr-2">
            <button title="Delete All" class="btn btn-danger delete_all" data-url="{{ url('deleteakun') }}"><i class="fas fa-trash"></i></button>
        </div> --}}
    </div>
    {{-- <div class="d-md-flex justify-content-md-end">
        <button title="Delete All" class="btn searchbox-submit delete_all" data-url="{{ url('deleteakun') }}"><i class="fas fa-trash"></i></button>
        <button title="Add" class="btn searchbox-submit" data-bs-toggle="modal" data-bs-target="#add"><i class="fas fa-plus"></i></button>
        <form class="searchbox" method="get" action="/searchakun">
            <button type="submit" class="searchbox-submit"><i class="fas fa-search" title="Search"></i></button>
            <input value="{{Request::get('search')}}" type="text" name="search" class="typeahead searchbox-input" autocomplete="off" placeholder="Cari akun" title="Search">
        </form>
    </div> --}}
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-center">
                        <tr>
                            {{-- <th><input type="checkbox" id="master"></th> --}}
                            <th width="10%" class="text-left">#</th>
                            <th>Nama Akun</th> 
                            <th>Kode Akun</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 1 ?>
                        @forelse($akun as $a)
                        <tr id="tr_{{$a->id}}">
                            {{-- <td><input type="checkbox" class="sub_chk" data-id="{{$a->id}}"></td> --}}
                            <td>{{$id++}}</td>
                            <td>{{ucwords($a->nama_akun)}}</td>
                            <td>{{$a->kd_akun}}</td>
                            <td class="text-center">
                                <button class="bg-transparent" title="Edit" style="border: none" data-bs-toggle="modal" data-bs-target="#edit{{$a->id}}"><i class="far fa-edit"></i></button>
                                <button class="bg-transparent" title="Delete" style="border: none" data-bs-toggle="modal" data-bs-target="#delete{{$a->id}}"><i class="fas fa-trash"></i></button>

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="delete{{$a->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Anda yakin ingin menghapus akun {{ucwords($a->nama_akun)}}?</div>
                                            <div class="modal-footer">
                                                <form action="/dakun/{{$a->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-outline-danger">Yes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                
                                {{-- Edit Modal --}}
                                <div class="modal fade text-left" id="edit{{$a->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Akun</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="/editakun/{{$a->id}}" enctype="multipart/form-data" id="editform">
                                                    @csrf
                                                    @method('put')   
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-4 col-form-label">Nama Akun</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" id="nama_akun" name="nama_akun" class="form-control" required="required" value="{{$a->nama_akun}}" autocomplete="off">
                                                                <input type="hidden" name="id" value="{{$a->id}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-4 col-form-label">Kode Akun</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" id="kd_akun" name="kd_akun" class="form-control" required="required" value="{{$a->kd_akun}}" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div> 
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-outline-primary">Update</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="7">
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

    {{-- Modal Add --}}
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/addakun" enctype="multipart/form-data">
                    {{ csrf_field() }}   
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Nama Akun</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nama_akun" class="form-control" required="required" value="{{old('name')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Kode Akun</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kd_akun" class="form-control" required="required" value="{{old('kd_akun')}}" autocomplete="off">
                                </div>
                            </div>
                        </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/typeahead3.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {
		    $('#example').DataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 3 ]}
                ],
                "order": [[ 0, "asc" ]],
                lengthMenu:[
                    [10,25,50,100,-1],
                    [10,25,50,100,"All"]
                ],
                dom: 
                "<'row'<'col-2 text-left'l>>"+
                "<'row'<'col-sm-12'tr>>"+
                "<'row'<'col-md-6'i><'col-md-6'p>>",
            });
		} );
	</script>
    <script type="text/javascript">
        var path = "{{ route('autocompleteakun3') }}";
            $('input.typeahead').typeahead({
                source:  function (terms, process) 
                {
                return $.get(path, { terms: terms }, function (data) {
                        return process(data);
                    });
                }
            });
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