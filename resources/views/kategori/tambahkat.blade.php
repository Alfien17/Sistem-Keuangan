@extends('main')
@section('judul_halaman','Data Kategori')
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
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            @endforeach
        </ul>
    </div>
    @endif

    @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
        <div class="wrapper">
            <div class="btn-add" data-bs-toggle="modal" data-bs-target="#add">
                <div class="icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span>Add</span>
            </div>
        </div>
    @endif

    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0">
                    <thead class="table-control text-center">
                        <tr>
                            <th width="20%" class="pl-5 text-left">#</th>
                            <th>Kategori</th>
                            @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                <th width="15%">Action</th>
                            @endif
                        </tr>    
                    </thead>
                    <tbody>
                        <?php $id = 1 ?>
                        @forelse($kat as $k)
                        <tr id="tr_{{$k->id}}">
                            <td class="pl-5">{{$id++}}</td>
                            <td>{{ucwords($k->name)}}</td>
                            @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                <td class="text-center">
                                    <button type="button" title="Edit" class="btn btn-outline-custom2" data-bs-toggle="modal" data-bs-target="#edit{{$k->id}}"><i class="far fa-edit text-dark"></i></button>
                                    <button type="button" title="Delete" class="btn btn-outline-custom2" data-bs-toggle="modal" data-bs-target="#delete{{$k->id}}"><i class="fas fa-trash text-dark"></i></button>

                                    {{-- Modal Delete --}}
                                    <div class="modal fade" id="delete{{$k->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Anda yakin ingin menghapus kategori {{ucwords($k->name)}}? <br>
                                                    Dengan menghapus kategori, data keuangan pada kategori <br>
                                                    {{ucwords($k->name)}} akan ikut terhapus.</div>
                                                <div class="modal-footer">
                                                    <form action="/dkat/{{$k->id}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-custom">Yes</button>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/editkategori/{{$k->id}}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('put')
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-4 col-form-label">Kategori</label>
                                                                <div class="col-sm-5">
                                                                    <input type="text" name="name" class="form-control effect" required="required" value="{{$k->name}}" autocomplete="off">
                                                                    <input type="hidden" name="id" value="{{$k->id}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-custom">Update</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="7">
                                <div class="content mx-auto m-5">
                                    <div class="icon"><i class="far fa-sad-tear"></i></div>
                                    <div class="text2 ml-4">Data Kosong.</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Add --}}
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/addkategori" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Kategori</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name" class="form-control effect" required="required" value="{{old('name')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-custom">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {
		    var table = $('#example').DataTable({
                    "order": [[ 0, "asc" ]],
                    language: {
                    search: "",
                    searchPlaceholder: "Search..."
                    },
                    lengthMenu:[
                        [10,25,50,100,-1],
                        [10,25,50,100,"All"]
                    ],
                    dom: 
                    "<'row'<'col-2 text-left'l><'col-10 text-right 'f>>" +
                    "<'row'<'col-sm-12'tr>>"+
                    "<'row'<'col-md-6'i><'col-md-6'p>>",
                });
		    } );
	</script>
@endsection	