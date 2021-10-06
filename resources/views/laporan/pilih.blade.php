@extends('main')
@section('judul_halaman','Pilih Akun')
@section('konten')
<br>
<div class="container">
	<form method="post" action="/main/laporan-specific/view" enctype="multipart/form-data">
	{{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Kode Akun</label>
                     <div class="col-sm-5">
                         <input name="kd_akun" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun')}}" autocomplete="off" class="form-control {{$errors->has('kd_akun')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...">
                         <datalist id="datalistOptions">
                         @foreach ($akun as $a)
                            <option value="{{$a->kd_akun}}">{{ucwords($a->nama_akun)}}
                        @endforeach
                        </datalist>
                        @error('kd_akun')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-7 text-right">
            	<a class="btn btn-light" href="/main">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </form>
</div>
@endsection	