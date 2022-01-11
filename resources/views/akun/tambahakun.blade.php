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
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            @endforeach
        </ul>  
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 pb-3">
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
                        <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                            <thead class="table-control text-center">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th data-priority="1">Nama Akun</th> 
                                    <th>Kode Akun</th>
                                    <th>Neraca Keuangan</th>
                                    <th>Saldo < 0</th>
                                    <th>Kategori</th>
                                    @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                        <th data-priority="2">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="text-left">
                                <?php $id = 1 ?>
                                @forelse($akun as $a)
                                <tr>
                                    <td>{{$id++}}</td>
                                    <td>{{ucwords(substr($a->nama_akun,0,23))}}</td>
                                    <td>{{$a->kd_akun}}</td>
                                    <td class="text-center">{{ucwords($a->posisi)}}</td>
                                    <td class="text-center">
                                        @if($a->check == 'true')
                                            <span class="badge rounded-pill bg-success">Yes</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>{{$a->katakun->kode}}</td>
                                    @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-custom2" title="Edit"  data-bs-toggle="modal" data-bs-target="#edit{{$a->id}}"><i class="far fa-edit"></i></button>
                                            <button type="button" class="btn btn-outline-custom2" title="Delete" data-bs-toggle="modal" data-bs-target="#delete{{$a->id}}"><i class="fas fa-trash"></i></button>

                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="delete{{$a->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Anda yakin ingin menghapus akun <br>
                                                            {{ucwords($a->nama_akun)}}? Dengan <br>
                                                            menghapus akun, data keuangan pada akun <br>
                                                            {{ucwords($a->nama_akun)}} 
                                                            akan ikut terhapus.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="/dakun/{{$a->id}}" method="post">
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
                                            <div class="modal fade text-left" id="edit{{$a->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Akun</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="/editakun/{{$a->id}}" enctype="multipart/form-data" id="editform">
                                                                @csrf
                                                                @method('put')   
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label class="col-4 col-form-label">Nama Akun</label>
                                                                        <div class="col-sm-5">
                                                                            <input type="text" id="nama_akun" name="nama_akun" class="form-control effect" required="required" value="{{$a->nama_akun}}" autocomplete="off">
                                                                            <input type="hidden" name="id" value="{{$a->id}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label class="col-4 col-form-label">Kode Akun</label>
                                                                        <div class="col-sm-5">
                                                                            <input type="text" id="kd_akun" name="kd_akun" class="form-control effect" required="required" value="{{$a->kd_akun}}" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label class="col-4 col-form-label">Posisi di Neraca Saldo</label>
                                                                        <div class="col-sm-5 pt-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio" name="posisi" value="debit" {{ ($a->posisi=="debit")? "checked" : "" }} required>
                                                                                <label class="form-check-label">Debit</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio" name="posisi" value="kredit" {{ ($a->posisi=="kredit")? "checked" : "" }} required>
                                                                                <label class="form-check-label">Kredit</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label class="col-4 col-form-label">Kategori</label>
                                                                        <div class="col-sm-5">
                                                                            <select class="effect-1 form-select" name="kategori" required onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=5;' onblur="this.size=0;"> 
                                                                                @if(!empty($a->katakun_id))
                                                                                    <option value="{{ $a->katakun_id }}" hidden>{{$a->katakun->kode}} - {{ ucwords($a->katakun->akun) }}</option>
                                                                                @else
                                                                                    <option value="" hidden="true">-Pilih-</option> 
                                                                                @endif
                                                                                @forelse($kategori as $k)
                                                                                    <option value="{{ $k->id }}" {{ old('kategori') == $k->akun ? "selected" : "" }}>{{$k->kode}} - {{ ucwords($k->akun) }}</option>
                                                                                @empty
                                                                                    <option value="" disabled>Silahkan tambah kategori di Tambah Kategori Akun</option>
                                                                                @endforelse
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
        </div>

        <div class="col-md-4">
            @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                <div class="wrapper">
                    <div class="btn-add" data-bs-toggle="modal" data-bs-target="#addkat">
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
                        <table style="font-size:13px" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                            <thead class="table-control text-center">
                                <tr>
                                    <th data-priority="1">Kode</th> 
                                    <th>Kategori</th>
                                    @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                @forelse($kategori as $k)
                                    <td>{{$k->kode}}</td>
                                    <td>{{ucwords(substr($k->akun,0,23))}}</td>
                                    @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
                                        <td class="text-center">
                                            <button type="button" style="font-size: 8px" class="btn btn-outline-custom2" title="Edit"  data-bs-toggle="modal" data-bs-target="#editkat{{$k->id}}"><i class="far fa-edit"></i></button>
                                            <button type="button" style="font-size: 8px" class="btn btn-outline-custom2" title="Delete" data-bs-toggle="modal" data-bs-target="#deletekat{{$k->id}}"><i class="fas fa-trash"></i></button>

                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="deletekat{{$k->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" style="font-size:15px">
                                                            Anda yakin ingin menghapus akun <br>
                                                            {{ucwords($k->akun)}}? Dengan <br>
                                                            menghapus akun, data keuangan pada akun <br>
                                                            {{ucwords($k->akun)}} 
                                                            akan ikut terhapus.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="/dkat-akun/{{$k->id}}" method="post">
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
                                            <div class="modal fade text-left" id="editkat{{$k->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Kategori Akun</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="/editkat-akun/{{$k->id}}" enctype="multipart/form-data" id="editform">
                                                                @csrf
                                                                @method('put')   
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label class="col-4 col-form-label">Nama</label>
                                                                        <div class="col-sm-5">
                                                                            <input type="text" id="akun" name="akun" class="form-control effect" required="required" value="{{$k->akun}}" autocomplete="off">
                                                                            <input type="hidden" name="id" value="{{$k->id}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label class="col-4 col-form-label">Kode</label>
                                                                        <div class="col-sm-5">
                                                                            <input type="text" id="kode" name="kode" class="form-control effect" required="required" value="{{$k->kode}}" autocomplete="off">
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
                                    <td colspan="3">
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
    </div>

    {{-- Modal Add Akun --}}
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/addakun" enctype="multipart/form-data">
                    {{ csrf_field() }}   
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Nama Akun</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nama_akun" class="form-control effect" required="required" value="{{old('nama_akun')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Kode Akun</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kd_akun" class="form-control effect" required="required" value="{{old('kd_akun')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Posisi di Neraca Saldo</label>
                                <div class="col-sm-5 pt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="posisi" value="debit" required>
                                        <label class="form-check-label">Debit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="posisi" value="kredit" required>
                                        <label class="form-check-label">Kredit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Kategori</label>
                                <div class="col-sm-5">
                                    <select class="effect-1 form-select" name="kategori" required onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=5;' onblur="this.size=0;">
                                        <option value="" hidden="true">-Pilih-</option> 
                                        @forelse($kategori as $k)
                                            <option value="{{ $k->id }}" {{ old('kategori') == $k->akun ? "selected" : "" }}>{{$k->kode}} - {{ ucwords($k->akun) }}</option>
                                        @empty
                                            <option value="" disabled>Silahkan tambah kategori di Tambah Kategori Akun</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="check" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Izinkan akun memiliki saldo kurang dari 0 (nol)</label>
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

    {{-- Modal Add Kategori Akun --}}
    <div class="modal fade" id="addkat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Akun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/addkat-akun" enctype="multipart/form-data">
                    {{ csrf_field() }}   
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Nama</label>
                                <div class="col-sm-5">
                                    <input type="text" name="akun" class="form-control effect" required="required" value="{{old('akun')}}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label">Kode</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kode" class="form-control effect" required="required" value="{{old('kode')}}" autocomplete="off">
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