@extends('main')
@section('judul_halaman','Detail Data User')
@section('konten')
<br>
<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main/datauser">Data User</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
    </nav>
    @foreach ($user as $u)
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 mb-2">
                    <div class="row">
                        <div class="col-3">
                            <label>Nama</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            <label>{{ucwords($u->name)}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Bagian</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            <label>{{ucwords($u->bagian)}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Email</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            <label>{{$u->email}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Telepon</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            <label>{{$u->telp}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Alamat</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            <label>{{ucfirst($u->al_detail)}}</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Gambar :</label><br>
                    <div class="card border-0" style="width: 15rem;" style="border: none">
                        <img src="{{ url('/assets/'.$u->image) }}" class="card-img-top p-3" alt="...">
                        @if($u->image != 'default/default2.png')
                        <div class="card-body">
                            <a href="{{ url('/assets/'.$u->image) }}" target="_blank">Lihat gambar</a>
                        </div>
                        @else
                        <div class="card-body">
                            <small>Tidak ada gambar.</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>	
    @endforeach
</div>
@endsection	