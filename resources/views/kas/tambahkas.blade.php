@extends('main')
@section('judul_halaman','Data Buku Kas')
@section('konten')
<br>
<div class="container">
    @if (count($errors)>0)
    <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
        <ul style="list-style:none">
            @foreach($errors->all() as $error)
            <li><span class="fas fa-exclamation-triangle"></span>
                {{$error}}
            </li>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="d-flex flex-row-reverse">
        <form action="/searchkas" method="get">
            <div class="input-group">
                <input value="{{Request::get('search')}}" type="search" name="search" class="typeahead form-control border-secondary" autocomplete="off" placeholder="Cari Kas..." title="Search">
                <button type="submit" class="btn btn-secondary"><i class="fas fa-search" title="Search"></i></button>
            </div>
        </form>
        <div class="pr-2">
            <button title="Add" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add"><i class="fas fa-plus"></i></button>   
        </div>
        {{-- <div class="pr-2">
            <button title="Delete All" class="btn btn-danger delete_all" data-url="{{ url('deletekas') }}"><i class="fas fa-trash"></i></button>
        </div> --}}
    </div>
    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-center">
                        <tr>
                            {{-- <th><input type="checkbox" id="master"></th> --}}
                            <th width="10%" class="text-left">#</th>
                            <th>Nama Kas</th>
                            <th>Cash/Cashless</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 1 ?>
                        @forelse($kas as $k)
                        <tr id="tr_{{$k->id}}">
                            {{-- <td><input type="checkbox" class="sub_chk" data-id="{{$k->id}}"></td> --}}
                            <td>{{$id++}}</td>
                            <td>{{ucwords($k->bk_kas)}}</td>
                            <td>{{$k->tipe}}</td>
                            <td class="text-center">
                                <button title="Edit" class="bg-transparent" style="border: none" data-bs-toggle="modal" data-bs-target="#edit{{$k->id}}"><i class="far fa-edit text-dark"></i></button>
                                <button title="Delete" class="bg-transparent" style="border: none" data-bs-toggle="modal" data-bs-target="#delete{{$k->id}}"><i class="fas fa-trash text-dark"></i></button>

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="delete{{$k->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Anda yakin ingin menghapus buku kas {{ucwords($k->bk_kas)}}?</div>
                                            <div class="modal-footer">
                                                <form action="/dkas/{{$k->id}}" method="post">
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
                                <div class="modal fade text-left" id="edit{{$k->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Buku Kas</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="/editkas/{{$k->id}}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-4 col-form-label">Nama Kas</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" name="bk_kas" class="form-control" required="required" value="{{$k->bk_kas}}" autocomplete="off">
                                                                <input type="hidden" name="id" value="{{$k->id}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-4 col-form-label">Cash/Cashless</label>
                                                            <div class="col-sm-5">
                                                                <select name="tipe" class="form-control" required>
                                                                    <option value="{{$k->tipe}}" selected hidden>{{$k->tipe}}</option>
                                                                    <option value="Cash">Cash</option>
                                                                    <option value="Cashless">Cashless</option>
                                                                    <option value="-">Kosongkan</option>
                                                                </select>
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

    {{-- Modal Add --}}
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/addkas" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Nama Kas</label>
                                <div class="col-sm-5">
                                    <input type="text" name="bk_kas" class="form-control" required="required" value="{{old('bk_kas')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Cash/Cashless</label>
                                <div class="col-sm-5">
                                    <select name="tipe" class="form-control" required>
                                        <option hidden="true">-Pilih-</option>
                                        <option value="Cash" @if (old('tipe')=='Cash' ) selected @endif>Cash</option>
                                        <option value="Cashless" @if (old('tipe')=='Cashless' ) selected @endif>Cashless</option>
                                        <option value="-" @if (old('tipe')=='-' ) selected @endif>Kosongkan</option>
                                    </select>
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
    <script type="text/javascript" src="/js/typeahead4.min.js"></script>
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
        var path = "{{ route('autocompletekas') }}";
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