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
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            @endforeach
        </ul>
    </div>
    @endif

    @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
        <div class="button btn-add3" data-bs-toggle="modal" data-bs-target="#add">
            <div class="circle">
                <span class="fas fa-plus"></span>
            </div>
            <p class="button-text pl-1">Tambah Buku Kas</p>
        </div>
    @endif

    <div class="card shadow mt-2">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                    <thead class="table-control text-center">
                        <tr>
                            <th width="10%" class="text-left">#</th>
                            <th data-priority="1">Nama Kas</th>
                            <th>Cash/Cashless</th>
                            @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                <th width="15%" data-priority="2">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="text-left">
                        <?php $id = 1 ?>
                        @forelse($kas as $k)
                        <tr>
                            <td>{{$id++}}</td>
                            <td>{{ucwords($k->bk_kas)}}</td>
                            <td>{{$k->tipe}}</td>
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
                                                <div class="modal-body">Anda yakin ingin menghapus buku kas <br>
                                                    {{ucwords($k->bk_kas)}}? Dengan menghapus <br>
                                                    buku kas, data keuangan pada buku kas <br>
                                                    {{ucwords($k->bk_kas)}} akan ikut terhapus.</div>
                                                <div class="modal-footer">
                                                    <form action="/dkas/{{$k->id}}" method="post">
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Buku Kas</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/editkas/{{$k->id}}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('put')
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-4 col-form-label">Nama Kas</label>
                                                                <div class="col-sm-5">
                                                                    <input type="text" name="bk_kas" class="form-control effect" required="required" value="{{$k->bk_kas}}" autocomplete="off">
                                                                    <input type="hidden" name="id" value="{{$k->id}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="col-4 col-form-label">Cash/Cashless</label>
                                                                <div class="col-sm-5">
                                                                    <select name="tipe" class="form-select effect" required onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Buku Kas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/addkas" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Nama Kas</label>
                                <div class="col-sm-5">
                                    <input type="text" name="bk_kas" class="form-control effect" required="required" value="{{old('bk_kas')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Cash/Cashless</label>
                                <div class="col-sm-5">
                                    <select name="tipe" class="form-select effect" required onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
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