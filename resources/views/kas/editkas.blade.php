@extends('main')
@section('judul_halaman','Edit Buku Kas')
@section('konten')
    @foreach($kas as $k)
    <form method="post" action="/editkas" enctype="multipart/form-data">
    {{ csrf_field() }}
        @if (count($errors)>0)
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <ul style="list-style:none">
                @foreach($errors->all() as $error)
                <li><span class="fas fa-exclamation-triangle"></span>
                {{$error}}</li>
                <button button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                @endforeach
            </ul>  
        </div>
        @endif
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label text-right">Nama Kas</label>
                    <div class="col-sm-5">
                        <input type="text" name="name" class="form-control" required="required" value="{{$k->name}}" autocomplete="off">
                        <input type="hidden" name="id" value="{{$k->id}}">
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label text-right">Cash/Cashless</label>
                    <div class="col-sm-5">
                    <select name="tipe" class="form-control" required>
                        <option value="{{$k->tipe}}"  selected hidden>{{$k->tipe}}</option>
                        <option value="Cash">Cash</option>
                        <option value="Cashless">Cashless</option>
                        <option value="-">Kosongkan</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-7 text-right">
                <a class="btn btn-light" href="/main/kas">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </div>
    </form>
    @endforeach
@endsection 