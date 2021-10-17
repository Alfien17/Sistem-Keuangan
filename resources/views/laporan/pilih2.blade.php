@extends('main')
@section('judul_halaman','Pilih Buku Kas')
@section('konten')
<br>
<div class="container">
	<form method="post" action="/main/laporan-kas/view" enctype="multipart/form-data">
	{{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Buku Kas</label>
                     <div class="col-sm-5">
                         <input name="bk_kas" list="datalistOptions" id="exampleDataList" value="{{old('bk_kas')}}" autocomplete="off" class="form-control {{$errors->has('bk_kas')?'is-invalid':''}}" type="text" placeholder="Ex BSI...">
                         <datalist id="datalistOptions">
                         @foreach ($kas as $k)
                            <option value="{{$k->bk_kas}}">
                        @endforeach
                        </datalist>
                        @error('bk_kas')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-7 text-right">
            	<a class="btn btn-light" href="/main/laporan-kas">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </form>
</div>
@endsection	