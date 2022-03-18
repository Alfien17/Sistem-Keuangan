@extends('main')
@section('judul_halaman','Data User')
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

    <div class="button btn-add" data-bs-toggle="modal" data-bs-target="#add">
        <div class="circle">
            <span class="fas fa-plus"></span>
        </div>
        <p class="button-text pl-1">Tambah User</p>
    </div>

    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-center">
                        <tr>
                            <th width="10%" class="text-left">#</th>
                            <th data-priority="1">Nama</th>
                            <th>Email</th>
                            <th data-priority="3">Bagian</th>
                            <th width="15%" data-priority="2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-left">
                        <?php $id = 1 ?>
                        @forelse($user as $u)
                        <tr>
                            <td>{{$id++}}</td>
                            <td>{{ucwords($u->name)}}</td>
                            <td>{{$u->email}}</td>
                            <td>{{ucwords($u->bagian)}}</td>
                            <td class="text-center">
                                <a type="button" class="btn btn-outline-custom2" href="/main/datauser/detail/{{$u->id}}" title="Detail"><i class="fas fa-info text-dark pl-1 pr-1"></i></a>
                                <button type="button" title="Edit" class="btn btn-outline-custom2" data-bs-toggle="modal" data-bs-target="#edit{{$u->id}}"><i class="far fa-edit text-dark"></i></button>
                                <button type="button" title="Delete" class="btn btn-outline-custom2" data-bs-toggle="modal" data-bs-target="#delete{{$u->id}}"><i class="fas fa-trash text-dark"></i></button>

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="delete{{$u->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">Anda yakin ingin menghapus user
                                                {{ucwords($u->name)}}?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="/duser/{{$u->id}}" method="post">
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
                                <div class="modal fade text-left" id="edit{{$u->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Bagian User</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="/euser/{{$u->id}}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-4 col-form-label">Bagian</label>
                                                            <div class="col-sm-5">
                                                                <select name="bagian" class="form-select effect" required>
                                                                    <option value="{{$u->bagian}}" selected hidden>{{ucwords($u->bagian)}}</option>
                                                                    <option value="admin">Admin</option>
                                                                    <option value="accounting">Accounting</option>
                                                                    <option value="cashier">Cashier</option>
                                                                    <option value="supervisor">Supervisor</option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="id" value="{{$u->id}}">
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
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="5">
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('postsignup')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Username</label>
                                <div class="col-sm-5">
                                    <input type="text" name="username" class="form-control effect" required="required" value="{{old('username')}}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-4 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name" class="form-control effect" required="required" value="{{old('name')}}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-4 col-form-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="email" name="email" class="form-control effect" required="required" value="{{old('email')}}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-4 col-form-label">Password</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password" class="form-control effect" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-4 col-form-label">Konfirmasi Password</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password_confirmation" class="form-control effect" required="required">
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
		    $('#example').DataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 4 ]}
                ],
                "order": [[ 0, "asc" ]],
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                },
                responsive: true,
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