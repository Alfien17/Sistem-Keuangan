@extends('main')
@section('judul_halaman','Edit Akun')
@section('konten')
<form method="post" action="/editakun" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal fade" id="edit{{$a->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">   
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label text-right">Nama Akun</label>
                                <div class="col-sm-5">
                                    <input type="text" name="nama_akun" class="form-control" required="required" value="{{$a->nama_akun}}" autocomplete="off">
                                    <input type="hidden" name="id" value="{{$a->id}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-4 col-form-label text-right">Kode Akun</label>
                                <div class="col-sm-5">
                                    <input type="text" name="kd_akun" class="form-control" required="required" value="{{$a->kd_akun}}" autocomplete="off">
                                </div>
                            </div>
                        </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection 